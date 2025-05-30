<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasProfilePhoto;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'whatsapp',
        'password',
        'last_login_at',
        'login_count',
        'failed_login_attempts',
        'login_locked_until',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'login_locked_until' => 'datetime',
        'login_count' => 'integer',
        'failed_login_attempts' => 'integer',
    ];

    /**
     * Mutator to set WhatsApp number.
     * Normalizes the number to a standard format.
     *
     * @param string|null $value
     * @return void
     */
    public function setWhatsappAttribute($value)
    {
        if ($value) {
            // Remove any non-numeric characters
            $value = preg_replace('/[^0-9]/', '', $value);
            
            // Convert 628xx to 08xx for storage
            if (substr($value, 0, 3) === '628') {
                $value = '08' . substr($value, 3);
            }
        }
        
        $this->attributes['whatsapp'] = $value;
    }

    /**
     * Accessor to get formatted WhatsApp number.
     *
     * @param string|null $value
     * @return string|null
     */
    public function getWhatsappFormattedAttribute()
    {
        if (!$this->whatsapp) {
            return null;
        }
        
        // Format as +628xxx-xxxx-xxxx
        $number = $this->whatsapp;
        if (substr($number, 0, 2) === '08') {
            $number = '628' . substr($number, 2);
        }
        
        // Add formatting
        if (strlen($number) >= 11) {
            return '+' . substr($number, 0, 4) . '-' . 
                   substr($number, 4, 4) . '-' . 
                   substr($number, 8);
        }
        
        return '+' . $number;
    }

    /**
     * Check if user account is locked due to failed login attempts.
     *
     * @return bool
     */
    public function isAccountLocked(): bool
    {
        return $this->failed_login_attempts >= 5 || 
               ($this->login_locked_until && $this->login_locked_until->isFuture());
    }

    /**
     * Get the lockout time remaining in minutes.
     *
     * @return int
     */
    public function getLockoutTimeRemaining(): int
    {
        if (!$this->isAccountLocked()) {
            return 0;
        }
        
        if ($this->login_locked_until && $this->login_locked_until->isFuture()) {
            return max(0, now()->diffInMinutes($this->login_locked_until, false));
        }
        
        // Assuming 15 minutes lockout from last failed attempt
        $lockoutMinutes = 15;
        $lastAttempt = $this->updated_at;
        $unlockTime = $lastAttempt->addMinutes($lockoutMinutes);
        
        return max(0, now()->diffInMinutes($unlockTime, false));
    }

    /**
     * Reset failed login attempts.
     *
     * @return void
     */
    public function resetFailedLoginAttempts(): void
    {
        $this->update([
            'failed_login_attempts' => 0,
            'login_locked_until' => null
        ]);
    }

    /**
     * Increment failed login attempts.
     *
     * @return void
     */
    public function incrementFailedLoginAttempts(): void
    {
        $this->increment('failed_login_attempts');
    }

    /**
     * Update last login information.
     *
     * @return void
     */
    public function updateLoginInfo(): void
    {
        $this->update([
            'last_login_at' => now(),
            'login_count' => $this->login_count + 1,
            'failed_login_attempts' => 0,
            'login_locked_until' => null,
        ]);
    }

    /**
     * Get display identifier (username, email, or formatted whatsapp).
     *
     * @return string
     */
    public function getDisplayIdentifierAttribute(): string
    {
        if ($this->username) {
            return $this->username;
        }
        
        if ($this->whatsapp) {
            return $this->whatsapp_formatted;
        }
        
        return $this->email;
    }

    /**
     * Scope a query to search users by identifier.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $identifier
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereIdentifier($query, $identifier)
    {
        return $query->where(function ($q) use ($identifier) {
            // Selalu cek email
            $q->where('email', $identifier);
            
            // Cek username jika kolom ada
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'username')) {
                $q->orWhere('username', $identifier);
            }
            
            // Cek whatsapp jika kolom ada
            if (\Illuminate\Support\Facades\Schema::hasColumn('users', 'whatsapp')) {
                // Normalize WhatsApp number jika terlihat seperti nomor HP
                if (preg_match('/^(\+62|62|0)[0-9]+$/', $identifier)) {
                    $whatsapp = preg_replace('/[^0-9]/', '', $identifier);
                    
                    // Konversi 628xxx ke 08xxx untuk pencocokan
                    if (substr($whatsapp, 0, 3) === '628') {
                        $whatsapp = '08' . substr($whatsapp, 3);
                    }
                    // Konversi 62xxx ke 08xxx
                    if (substr($whatsapp, 0, 2) === '62' && strlen($whatsapp) > 10) {
                        $whatsapp = '08' . substr($whatsapp, 2);
                    }
                    
                    $q->orWhere('whatsapp', $whatsapp)
                      ->orWhere('whatsapp', $identifier); // Coba juga format asli
                } else {
                    $q->orWhere('whatsapp', $identifier);
                }
            }
            
            // Fallback ke kolom phone jika whatsapp tidak ada
            if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'whatsapp') && 
                \Illuminate\Support\Facades\Schema::hasColumn('users', 'phone')) {
                if (preg_match('/^(\+62|62|0)[0-9]+$/', $identifier)) {
                    $phone = preg_replace('/[^0-9]/', '', $identifier);
                    if (substr($phone, 0, 3) === '628') {
                        $phone = '08' . substr($phone, 3);
                    }
                    if (substr($phone, 0, 2) === '62' && strlen($phone) > 10) {
                        $phone = '08' . substr($phone, 2);
                    }
                    $q->orWhere('phone', $phone)
                      ->orWhere('phone', $identifier);
                } else {
                    $q->orWhere('phone', $identifier);
                }
            }
        });
    }
    
    /**
     * Get all event registrations for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventRegistrations()
    {
        return $this->hasMany(EventRegistration::class);
    }
    
    /**
     * Get the URL to the user's profile photo.
     *
     * @return string
     */
    public function getProfilePhotoUrlAttribute()
    {
        // Check if user has profile photo in profiles table
        $profile = \App\Models\Profile::where('user_id', $this->id)->first();
        
        if ($profile && $profile->profile_photo) {
            // Check if photo is stored in public folder directly
            if (file_exists(public_path($profile->profile_photo))) {
                return asset($profile->profile_photo);
            }
            // Check if photo is in storage folder
            elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($profile->profile_photo)) {
                return asset('storage/' . $profile->profile_photo);
            }
        }
        
        // Return default avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
    
    /**
     * Update the user's profile photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updateProfilePhoto($photo)
    {
        // Get or create profile
        $profile = \App\Models\Profile::firstOrCreate(
            ['user_id' => $this->id],
            ['user_id' => $this->id]
        );
        
        // Delete old photo if exists
        if ($profile->profile_photo) {
            // Delete from storage
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($profile->profile_photo)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->profile_photo);
            }
            // Also delete from public folder if exists
            $oldPublicPath = public_path($profile->profile_photo);
            if (file_exists($oldPublicPath)) {
                unlink($oldPublicPath);
            }
        }
        
        try {
            // Check if photo is valid
            if (!$photo || !$photo->isValid() || $photo->getSize() == 0) {
                throw new \Exception('Invalid or empty file');
            }
            
            // Use manual approach for better compatibility with Windows
            $storageDir = public_path('profile-photos');
            
            // Create directory if not exists
            if (!is_dir($storageDir)) {
                if (!mkdir($storageDir, 0755, true)) {
                    throw new \Exception('Failed to create storage directory');
                }
            }
            
            // Check if directory is writable
            if (!is_writable($storageDir)) {
                throw new \Exception('Storage directory is not writable');
            }
            
            // Generate filename
            $extension = strtolower($photo->getClientOriginalExtension()) ?: 'jpg';
            $filename = 'profile_' . $this->id . '_' . time() . '.' . $extension;
            $relativePath = 'profile-photos/' . $filename;
            $fullPath = $storageDir . DIRECTORY_SEPARATOR . $filename;
            
            // Log attempt
            \Illuminate\Support\Facades\Log::info('Attempting to save profile photo', [
                'user_id' => $this->id,
                'filename' => $filename,
                'storage_dir' => $storageDir,
                'full_path' => $fullPath,
                'temp_path' => $photo->getRealPath(),
                'file_size' => $photo->getSize()
            ]);
            
            // Move file to public directory
            if (!$photo->move($storageDir, $filename)) {
                throw new \Exception('Failed to move uploaded file');
            }
            
            // Verify file exists
            if (!file_exists($fullPath)) {
                throw new \Exception('File not found after moving');
            }
            
            // Update profile
            $profile->update([
                'profile_photo' => $relativePath
            ]);
            
            \Illuminate\Support\Facades\Log::info('Profile photo saved successfully', [
                'user_id' => $this->id,
                'path' => $relativePath
            ]);
            
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to store profile photo in User model', [
                'user_id' => $this->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    
    /**
     * Delete the user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        $profile = \App\Models\Profile::where('user_id', $this->id)->first();
        
        if ($profile && $profile->profile_photo) {
            // Delete file
            \Illuminate\Support\Facades\Storage::disk('public')->delete($profile->profile_photo);
            
            // Update database
            $profile->update([
                'profile_photo' => null
            ]);
        }
    }
}
