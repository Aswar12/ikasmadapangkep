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
        // Debug: Log the request details
        if (config('app.debug')) {
            \Log::info('Login attempt', [
                'login' => $request->input('login'),
                'csrf_token' => $request->input('_token'),
                'session_id' => session()->getId(),
                'request_headers' => $request->headers->all()
            ]);
        }
        
        $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'login.required' => 'Email/Username/WhatsApp wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

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
                'time' => time(), // Use Unix timestamp
            ]);

            return back()->withErrors([
                'login' => 'Email/Username/WhatsApp atau kata sandi salah.',
            ])->onlyInput('login');
        }

        // Check if user is active
        if (!$user->active) {
            return back()->withErrors([
                'login' => 'Akun Anda belum diaktivasi. Silakan tunggu persetujuan admin.',
            ])->onlyInput('login');
        }

        // Log the user in manually
        Auth::login($user, $request->boolean('remember'));

        // Record successful login
        LoginAttempt::create([
            'ip_address' => $request->ip(),
            'login' => $request->login,
            'success' => true,
            'time' => time(), // Use Unix timestamp
        ]);

        // Update user's last login info
        $user->update([
            'last_login' => now(),
        ]);

        $request->session()->regenerate();

        // Redirect based on role
        switch ($user->role) {
            case 'admin':
                return redirect()->intended(route('admin.dashboard'));
            case 'department_coordinator':
                return redirect()->intended(route('coordinator.dashboard'));
            case 'alumni':
                return redirect()->intended(route('alumni.dashboard'));
            case 'sub_admin':
                return redirect()->intended(route('admin.dashboard'));
            default:
                return redirect()->intended('/');
        }
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
