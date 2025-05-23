<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $request->validate(User::loginValidationRules());

        // Check for too many failed attempts
        $failedAttempts = LoginAttempt::getRecentFailedAttempts($request->login);
        if ($failedAttempts >= 5) {
            return back()->withErrors([
                'login' => 'Terlalu banyak percobaan login gagal. Silakan coba lagi nanti atau reset password Anda.',
            ])->onlyInput('login');
        }

        // Find user by email, username, or phone
        $user = User::findForLogin($request->login);
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            // Record failed login attempt
            LoginAttempt::create([
                'ip_address' => $request->ip(),
                'login' => $request->login,
                'success' => false,
                'time' => time(),
            ]);

            return back()->withErrors([
                'login' => 'Email/Username/WhatsApp atau kata sandi salah.',
            ])->onlyInput('login');
        }

        // Check if user is active and approved
        if (!$user->active || !$user->approved) {
            if (!$user->email_verified_at) {
                return back()->withErrors([
                    'login' => 'Silakan verifikasi email Anda terlebih dahulu.',
                ])->onlyInput('login');
            } elseif (!$user->approved) {
                return redirect()->route('approval.pending');
            } else {
                return back()->withErrors([
                    'login' => 'Akun Anda belum diaktivasi. Silakan tunggu persetujuan admin.',
                ])->onlyInput('login');
            }
        }

        // Attempt to log in
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Check if user is active and approved
            if (!$user->active || !$user->approved) {
                Auth::logout();
                if (!$user->email_verified_at) {
                    return back()->withErrors([
                        'login' => 'Silakan verifikasi email Anda terlebih dahulu.',
                    ])->onlyInput('login');
                } elseif (!$user->approved) {
                    return redirect()->route('approval.pending');
                } else {
                    return back()->withErrors([
                        'login' => 'Akun Anda belum diaktivasi. Silakan tunggu persetujuan admin.',
                    ])->onlyInput('login');
                }
            }

            // Record successful login
            LoginAttempt::create([
                'ip_address' => $request->ip(),
                'login' => $request->login,
                'success' => true,
                'time' => time(),
            ]);

            // Update user's last login info
            $user->update([
                'last_login' => now(),
                'ip_address' => $request->ip()
            ]);

            $request->session()->regenerate();

            // Redirect based on role
            switch ($user->role) {
                case 'admin':
                case 'sub_admin':
                    return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
                case 'department_coordinator':
                    return redirect()->intended(RouteServiceProvider::COORDINATOR_HOME);
                default:
                    return redirect()->intended(RouteServiceProvider::HOME);
            }
        }

        // Record failed login attempt
        LoginAttempt::create([
            'ip_address' => $request->ip(),
            'login' => $request->login,
            'success' => false,
        ]);

        return back()->withErrors([
            'login' => 'Email/Username atau password salah.',
        ])->onlyInput('login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
