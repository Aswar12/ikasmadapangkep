<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Check for too many failed attempts
        $failedAttempts = LoginAttempt::getRecentFailedAttempts($request->email);
        if ($failedAttempts >= 5) {
            return back()->withErrors([
                'email' => 'Too many failed login attempts. Please try again later or reset your password.',
            ])->onlyInput('email');
        }

        // Attempt to log in
        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Record successful login
            LoginAttempt::create([
                'ip_address' => $request->ip(),
                'email' => $request->email,
                'success' => true,
            ]);

            // Check if user is approved and active
            if (!$user->isApproved()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is pending approval from admin.',
                ])->onlyInput('email');
            }

            if (!$user->isActive()) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Your account is inactive. Please contact administrator.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();

            return redirect()->intended(RouteServiceProvider::HOME);
        }

        // Record failed login attempt
        LoginAttempt::create([
            'ip_address' => $request->ip(),
            'email' => $request->email,
            'success' => false,
        ]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
