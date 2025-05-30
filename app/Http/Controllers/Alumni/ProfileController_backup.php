<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the profile.
     */
    public function index()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        
        return view('alumni.profile.index', compact('user', 'profile'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->firstOrNew(['user_id' => $user->id]);
        
        return view('alumni.profile.edit', compact('user', 'profile'));
    }

    /**
     * Update the profile in storage.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Handle photo-only save request
        if ($request->get('save_photo') && $request->hasFile('profile_photo')) {
            return $this->saveProfilePhoto($request, $user);
        }
        
        // Handle date conversion from separate fields
        $birthDate = null;
        if ($request->birth_date_year && $request->birth_date_month && $request->birth_date_day) {
            $birthDate = $request->birth_date_year . '-' . 
                        str_pad($request->birth_date_month, 2, '0', STR_PAD_LEFT) . '-' . 
                        str_pad($request->birth_date_day, 2, '0', STR_PAD_LEFT);
        }
        
        // Validate user data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            
            // Profile data - semuanya nullable sesuai permintaan
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'birth_place' => 'nullable|string|max:255',
            'birth_date_day' => 'nullable|integer|min:1|max:31',
            'birth_date_month' => 'nullable|integer|min:1|max:12',
            'birth_date_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'national_student_number' => 'nullable|string|max:255', // NISN - nullable
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'father_name' => 'nullable|string|max:255', // Nama ayah - nullable
            'father_occupation' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255', // Nama ibu - nullable
            'mother_occupation' => 'nullable|string|max:255', // Pekerjaan ibu - nullable
            'entry_year' => 'nullable|string|max:4',
            'graduation_year' => 'nullable|string|max:4',
            'diploma_number' => 'nullable|string|max:255',
            'certificate_number' => 'nullable|string|max:255', // SKHUN - nullable
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Prepare profile data
        $profileData = $request->only([
            'gender',
            'birth_place',
            'national_student_number',
            'address',
            'phone_number',
            'father_name',
            'father_occupation',
            'mother_name',
            'mother_occupation',
            'entry_year',
            'graduation_year',
            'diploma_number',
            'certificate_number'
        ]);
        
        // Add birth_date if constructed from separate fields
        if ($birthDate) {
            $profileData['birth_date'] = $birthDate;
        }
        
        // Update or create profile
        $profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
            $profileData
        );

        // Handle profile photo upload (for regular form submission)
        if ($request->hasFile('profile_photo') && $request->file('profile_photo')->isValid()) {
            $this->saveProfilePhoto($request, $user, $profile);
        }

        return redirect()->route('alumni.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }
    
    /**
     * Save profile photo separately
     */
    private function saveProfilePhoto(Request $request, $user, $profile = null)
    {
        // Try Laravel standard method first, then fallback to manual method
        try {
            return $this->saveProfilePhotoLaravel($request, $user, $profile);
        } catch (\Exception $e) {
            Log::warning('Laravel method failed, trying manual method', ['error' => $e->getMessage()]);
            return $this->saveProfilePhotoManual($request, $user, $profile);
        }
    }
    
    /**
     * Save profile photo using Laravel's built-in methods
     */
    private function saveProfilePhotoLaravel(Request $request, $user, $profile = null)
    {
        // Validate only photo field
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $file = $request->file('profile_photo');
        
        if (!$file || !$file->isValid()) {
            throw new \Exception('File tidak valid atau rusak.');
        }
        
        // Get or create profile
        if (!$profile) {
            $profile = Profile::where('user_id', $user->id)->first();
            if (!$profile) {
                $profile = Profile::create(['user_id' => $user->id]);
            }
        }
        
        // Delete old photo if exists
        if ($profile->profile_photo && Storage::disk('public')->exists($profile->profile_photo)) {
            Storage::disk('public')->delete($profile->profile_photo);
        }
        
        // Ensure directory exists
        $storagePath = storage_path('app/public/profile-photos');
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
        
        // Generate filename
        $extension = $file->getClientOriginalExtension();
        $filename = 'profile_' . $user->id . '_' . time() . '.' . $extension;
        
        // Store using Laravel's storage
        $path = Storage::disk('public')->putFileAs('profile-photos', $file, $filename);
        
        if (!$path) {
            throw new \Exception('Gagal menyimpan file dengan Laravel Storage.');
        }
        
        if (empty($path)) {
            \Log::error('Profile photo path is empty after saving file', ['user_id' => $user->id]);
            throw new \Exception('Path must not be empty');
        }
        
        // Update profile
        $profile->update(['profile_photo' => $path]);
        
        // Return response
        if ($request->ajax() || $request->get('save_photo')) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Foto profil berhasil diperbarui!',
                    'photo_url' => asset('storage/' . $path)
                ]);
            }
            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
        }
        
        return true;
    }
    
    /**
     * Save profile photo using manual file operations
     */
    private function saveProfilePhotoManual(Request $request, $user, $profile = null)
    {
        // Validate only photo field
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $file = $request->file('profile_photo');
        
        // Comprehensive file validation
        if (!$file || !$file->isValid()) {
            $errorMsg = 'File tidak valid atau rusak.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $errorMsg], 400);
            }
            return back()->withErrors(['profile_photo' => $errorMsg]);
        }
        
        // Check file properties
        $originalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $mimeType = $file->getClientMimeType();
        
        if (empty($originalName) || $fileSize == 0) {
            $errorMsg = 'File tidak valid atau kosong.';
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $errorMsg], 400);
            }
            return back()->withErrors(['profile_photo' => $errorMsg]);
        }
        
        try {
            // Debug info
            Log::info('Manual photo upload attempt', [
                'user_id' => $user->id,
                'file_name' => $originalName,
                'file_size' => $fileSize,
                'mime_type' => $mimeType
            ]);
            
            // Get or create profile if not provided
            if (!$profile) {
                $profile = Profile::where('user_id', $user->id)->first();
                if (!$profile) {
                    $profile = Profile::create(['user_id' => $user->id]);
                }
            }
            
            // Simple approach - use storage_path directly
            $storageDir = storage_path('app/public/profile-photos');
            
            if (!is_dir($storageDir)) {
                mkdir($storageDir, 0755, true);
            }
            
            // Delete old photo
            if ($profile->profile_photo) {
                $oldPath = storage_path('app/public/' . $profile->profile_photo);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
            
            // Generate filename
            $extension = strtolower($file->getClientOriginalExtension()) ?: 'jpg';
            $filename = 'profile_' . $user->id . '_' . time() . '.' . $extension;
            $fullPath = $storageDir . '/' . $filename;
            
            // Simple file copy
            if (copy($file->getRealPath(), $fullPath)) {
                $relativePath = 'profile-photos/' . $filename;
                $profile->update(['profile_photo' => $relativePath]);
                
                // Return response
                if ($request->ajax() || $request->get('save_photo')) {
                    if ($request->ajax()) {
                        return response()->json([
                            'success' => true, 
                            'message' => 'Foto profil berhasil diperbarui (manual)!',
                            'photo_url' => asset('storage/' . $relativePath)
                        ]);
                    }
                    return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
                }
                
                return true;
            } else {
                throw new \Exception('Gagal menyalin file.');
            }
            
        } catch (\Exception $e) {
            $errorMsg = 'Error manual upload: ' . $e->getMessage();
            
            Log::error('Manual photo upload error', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'file_name' => $originalName ?? 'unknown'
            ]);
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $errorMsg], 500);
            }
            return back()->withErrors(['profile_photo' => $errorMsg]);
        }
    }
}
