<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Models\Profile;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisterController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:'.User::class,
                'regex:/^[a-zA-Z0-9_-]+$/'
            ],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'max:20', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
            'graduation_year' => ['required', 'string', 'max:4'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'graduation_year' => $request->graduation_year,
            'password' => Hash::make($request->password),
            'role' => 'alumni',
            'active' => false,
            'approved' => false,
            'registration_date' => now(),
            'email_verified_at' => now(), // Auto verify email
        ]);

        // Create empty profile
        Profile::create([
            'user_id' => $user->id,
            'graduation_year' => $request->graduation_year,
            'phone' => $request->phone,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('approval.pending');
    }
}
