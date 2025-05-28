<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        
        // Validate user data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            
            // Profile data
            'gender' => 'nullable|in:Laki-laki,Perempuan',
            'birth_place' => 'nullable|string|max:255',
            'birth_date' => 'nullable|date',
            'national_student_number' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'phone_number' => 'nullable|string|max:20',
            'father_name' => 'nullable|string|max:255',
            'father_occupation' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'mother_occupation' => 'nullable|string|max:255',
            'entry_year' => 'nullable|string|max:4',
            'graduation_year' => 'nullable|string|max:4',
            'diploma_number' => 'nullable|string|max:255',
            'certificate_number' => 'nullable|string|max:255',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Update user data
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        // Update or create profile
        $profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'gender',
                'birth_place',
                'birth_date',
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
            ])
        );

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($profile->profile_photo && Storage::exists($profile->profile_photo)) {
                Storage::delete($profile->profile_photo);
            }

            // Store new photo
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $profile->update(['profile_photo' => $path]);
        }

        return redirect()->route('alumni.profile')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
