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
        
        // Handle date conversion from separate fields
        $birthDate = null;
        if ($request->birth_date_year && $request->birth_date_month && $request->birth_date_day) {
            $birthDate = $request->birth_date_year . '-' . 
                        str_pad($request->birth_date_month, 2, '0', STR_PAD_LEFT) . '-' . 
                        str_pad($request->birth_date_day, 2, '0', STR_PAD_LEFT);
        }
        
        // Validate user data (NO PROFILE PHOTO VALIDATION HERE)
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

        return redirect()->route('alumni.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }
    
    /**
     * Update profile photo only (separate from main profile form)
     */
    public function updateProfilePhoto(Request $request)
    {
        // Debug logging
        Log::info('updateProfilePhoto called', [
            'hasFile' => $request->hasFile('profile_photo'),
            'files' => $request->files->all(),
            'all_input' => $request->all()
        ]);
        
        // Check if file exists
        if (!$request->hasFile('profile_photo')) {
            Log::error('No file uploaded', [
                'files' => $_FILES,
                'request_content' => $request->getContent(),
                'request_all' => $request->all()
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada file yang diupload. Silakan pilih file terlebih dahulu.'
                ], 400);
            }
            return redirect()->back()->withErrors(['profile_photo' => 'Tidak ada file yang diupload.']);
        }
        
        // Validate photo upload
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = Auth::user();
        $file = $request->file('profile_photo');
        
        // Additional file validation
        if (!$file || !$file->isValid()) {
            Log::error('Invalid file', [
                'file' => $file,
                'error' => $file ? $file->getError() : 'No file object'
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File tidak valid atau rusak.'
                ], 400);
            }
            return redirect()->back()->withErrors(['profile_photo' => 'File tidak valid atau rusak.']);
        }
        
        try {
            // Use Jetstream's built-in profile photo functionality only
            Log::info('Attempting to upload profile photo using Jetstream method', [
                'user_id' => $user->id,
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'mime_type' => $file->getMimeType(),
                'temp_path' => $file->getRealPath()
            ]);
            
            $user->updateProfilePhoto($file);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto profil berhasil diperbarui!',
                    'photo_url' => $user->profile_photo_url
                ]);
            }
            
            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
            
        } catch (\Exception $e) {
            Log::error('Profile photo update failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui foto profil: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()->withErrors(['profile_photo' => 'Gagal memperbarui foto profil.']);
        }
    }
    
    /**
     * Delete profile photo
     */
    public function deletePhoto()
    {
        $user = Auth::user();
        
        try {
            $user->deleteProfilePhoto();
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto profil berhasil dihapus!'
                ]);
            }
            
            return redirect()->back()->with('success', 'Foto profil berhasil dihapus!');
            
        } catch (\Exception $e) {
            Log::error('Profile photo delete failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus foto profil.'
                ], 500);
            }
            
            return redirect()->back()->withErrors(['profile_photo' => 'Gagal menghapus foto profil.']);
        }
    }
    
    /**
     * Save profile photo separately - improved version
     * Note: This method is now deprecated in favor of Jetstream's built-in profile photo feature
     * Kept for backward compatibility
     */
    private function saveProfilePhoto(Request $request, $user, $profile = null)
    {
        // Always try manual method first as it's more reliable on Windows
        try {
            return $this->saveProfilePhotoManual($request, $user, $profile);
        } catch (\Exception $e) {
            Log::warning('Manual method failed, trying Laravel method', ['error' => $e->getMessage()]);
            try {
                return $this->saveProfilePhotoLaravel($request, $user, $profile);
            } catch (\Exception $e2) {
                Log::error('Both upload methods failed', [
                    'manual_error' => $e->getMessage(),
                    'laravel_error' => $e2->getMessage()
                ]);
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false, 
                        'message' => 'Gagal upload foto: ' . $e->getMessage()
                    ], 500);
                }
                return back()->withErrors(['profile_photo' => 'Gagal upload foto: ' . $e->getMessage()]);
            }
        }
    }
    
    /**
     * Save profile photo using Laravel's built-in methods - improved version
     */
    private function saveProfilePhotoLaravel(Request $request, $user, $profile = null)
    {
        // Validate only photo field
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
        
        $file = $request->file('profile_photo');
        
        if (!$file || !$file->isValid() || $file->getSize() == 0) {
            throw new \Exception('File tidak valid, rusak, atau kosong.');
        }
        
        // Double check file path exists
        $tempPath = $file->getRealPath();
        if (!$tempPath || !file_exists($tempPath)) {
            throw new \Exception('File temporary path tidak ditemukan.');
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
        $storagePath = public_path('profile-photos');
        if (!is_dir($storagePath)) {
            mkdir($storagePath, 0755, true);
        }
        
        // Generate filename
        $extension = $file->getClientOriginalExtension();
        $filename = 'profile_' . $user->id . '_' . time() . '.' . $extension;
        
        $fullPath = $storagePath . DIRECTORY_SEPARATOR . $filename;
        
        Log::info('Attempting manual storage upload', [
            'user_id' => $user->id,
            'filename' => $filename,
            'storage_path_exists' => is_dir($storagePath),
            'storage_path_writable' => is_writable($storagePath),
            'full_path' => $fullPath
        ]);
        
        try {
            // Move uploaded file to public/profile-photos
            $file->move($storagePath, $filename);
            
            // Update profile
            $profile->update(['profile_photo' => 'profile-photos/' . $filename]);
            
            Log::info('Profile photo successfully saved manually', [
                'user_id' => $user->id,
                'final_path' => $fullPath
            ]);
            
        } catch (\Exception $e) {
            Log::error('Manual storage failed detailed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'storage_path' => $storagePath,
                'full_path' => $fullPath,
                'is_dir' => is_dir($storagePath),
                'is_writable' => is_writable($storagePath)
            ]);
            throw $e;
        }
        
        // Return response
        if ($request->ajax() || $request->get('save_photo')) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Foto profil berhasil diperbarui!',
                    'photo_url' => asset($profile->profile_photo)
                ]);
            }
            return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
        }
        
        return true;
    }
    
    
    /**
     * Save profile photo using manual file operations - improved version
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
            throw new \Exception('File tidak valid atau rusak.');
        }
        
        // Check file properties
        $originalName = $file->getClientOriginalName();
        $fileSize = $file->getSize();
        $mimeType = $file->getClientMimeType();
        $tempPath = $file->getRealPath();
        
        if (empty($originalName) || $fileSize == 0 || !file_exists($tempPath)) {
            throw new \Exception('File tidak valid atau kosong.');
        }
        
        Log::info('Manual photo upload starting', [
            'user_id' => $user->id,
            'file_name' => $originalName,
            'file_size' => $fileSize,
            'mime_type' => $mimeType,
            'temp_path' => $tempPath,
            'temp_exists' => file_exists($tempPath)
        ]);
        
        // Get or create profile if not provided
        if (!$profile) {
            $profile = Profile::where('user_id', $user->id)->first();
            if (!$profile) {
                $profile = Profile::create(['user_id' => $user->id]);
            }
        }
        
        // Setup directories
        $storageDir = public_path('profile-photos');
        
        // Create directory if not exist
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }
        
        // Delete old photo
        if ($profile->profile_photo) {
            $oldPublicPath = public_path($profile->profile_photo);
            
            if (file_exists($oldPublicPath)) {
                unlink($oldPublicPath);
            }
        }
        
        // Generate filename
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'jpg';
        $filename = 'profile_' . $user->id . '_' . time() . '.' . $extension;

        // Validate filename and paths are not empty
        if (empty($filename)) {
            throw new \Exception('Generated filename is empty.');
        }

        $publicFullPath = $storageDir . '/' . $filename;
        $relativePath = 'profile-photos/' . $filename;

        if (empty($publicFullPath) || empty($relativePath)) {
            throw new \Exception('File path must not be empty.');
        }

        // Check if storage directory exists and is writable
        if (!is_dir($storageDir)) {
            Log::warning('Storage directory does not exist, attempting to create', ['storageDir' => $storageDir]);
            if (!mkdir($storageDir, 0755, true)) {
                Log::error('Failed to create storage directory', ['storageDir' => $storageDir]);
                throw new \Exception('Failed to create storage directory: ' . $storageDir);
            }
        }
        if (!is_writable($storageDir)) {
            Log::error('Storage directory is not writable', ['storageDir' => $storageDir]);
            throw new \Exception('Storage directory is not writable: ' . $storageDir);
        }

        try {
            Log::info('Before copying file', [
                'tempPath' => $tempPath,
                'publicFullPath' => $publicFullPath,
                'tempPathExists' => file_exists($tempPath),
                'storageDirExists' => is_dir($storageDir),
                'storageDirWritable' => is_writable($storageDir)
            ]);
            // Copy to public directory for direct access
            if (!copy($tempPath, $publicFullPath)) {
                Log::error('Failed to copy file', [
                    'tempPath' => $tempPath,
                    'publicFullPath' => $publicFullPath
                ]);
                throw new \Exception('Gagal menyalin file ke public directory');
            }

            // Verify file exists
            if (!file_exists($publicFullPath)) {
                throw new \Exception('File tidak ditemukan setelah copy');
            }

            // Update profile
            $profile->update(['profile_photo' => $relativePath]);

            Log::info('Profile photo successfully saved manually', [
                'user_id' => $user->id,
                'filename' => $filename,
                'public_path' => $publicFullPath,
                'relative_path' => $relativePath,
                'file_size_final' => filesize($publicFullPath)
            ]);

            // Return response
            if ($request->ajax() || $request->get('save_photo')) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Foto profil berhasil diperbarui!',
                        'photo_url' => asset($relativePath)
                    ]);
                }
                return redirect()->back()->with('success', 'Foto profil berhasil diperbarui!');
            }

            return true;

        } catch (\Exception $e) {
            Log::error('Manual photo upload error', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'storage_dir_exists' => is_dir($storageDir),
                'storage_dir_writable' => is_writable($storageDir),
                'temp_file_exists' => file_exists($tempPath)
            ]);
            throw $e;
        }
    }
}
