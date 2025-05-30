<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // DISABLED - Check rate limiting
        // $this->checkTooManyFailedAttempts($request);

        // Attempt to log the user in
        if ($this->attemptLogin($request)) {
            // DISABLED - Reset the rate limiter
            // $this->clearLoginAttempts($request);
            
            // Get the authenticated user
            $user = Auth::user();
            
            // Update login information (but skip failed attempts reset)
            $user->update([
                'last_login_at' => now(),
                'login_count' => $user->login_count + 1,
            ]);
            
            // Regenerate session
            $request->session()->regenerate();

            // Return response
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil! Selamat datang kembali, ' . $user->name,
                    'redirect' => $this->redirectPath()
                ]);
            }

            return redirect()->intended($this->redirectPath())
                ->with('success', 'Login berhasil! Selamat datang kembali, ' . $user->name);
        }

        // DISABLED - Increment the rate limiter
        // $this->incrementLoginAttempts($request);

        // DISABLED - Find user to check account lock status and increment failed attempts
        // $identifier = $request->input('login');
        // $user = User::whereIdentifier($identifier)->first();
        // if ($user) {
        //     $user->incrementFailedLoginAttempts();
        //     if ($user->failed_login_attempts >= 5 && !$user->login_locked_until) {
        //         $user->update(['login_locked_until' => now()->addMinutes(15)]);
        //     }
        //     if ($user->isAccountLocked()) {
        //         $minutes = $user->getLockoutTimeRemaining();
        //         $message = "Akun Anda terkunci karena terlalu banyak percobaan login yang gagal. Silakan coba lagi dalam {$minutes} menit.";
        //         if ($request->expectsJson()) {
        //             return response()->json([
        //                 'success' => false,
        //                 'message' => $message,
        //                 'errors' => ['login' => [$message]]
        //             ], 423);
        //         }
        //         throw ValidationException::withMessages([
        //             'login' => [$message],
        //         ]);
        //     }
        // }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $messages = [
            'login.required' => 'Email, username, atau nomor WhatsApp wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal :min karakter.',
            'g-recaptcha-response.required' => 'Mohon verifikasi bahwa Anda bukan robot.',
            'g-recaptcha-response.captcha' => 'Verifikasi captcha gagal. Silakan coba lagi.',
        ];

        $rules = [
            'login' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6'],
        ];

        // Add captcha validation if enabled
        if (config('services.recaptcha.enabled', false)) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        $request->validate($rules, $messages);

        // Additional validation for login identifier
        $login = $request->input('login');
        
        // Check if it's email
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            // Valid email format
            return;
        }
        
        // Check if it's username (alphanumeric, min 5 chars)
        if (preg_match('/^[a-zA-Z0-9_]{5,}$/', $login)) {
            // Valid username format
            return;
        }
        
        // Check if it's WhatsApp number
        if (preg_match('/^(\+62|62|0)[0-9]{8,13}$/', $login)) {
            // Valid WhatsApp format
            return;
        }
        
        // If none of the above, throw validation error
        throw ValidationException::withMessages([
            'login' => ['Format email, username, atau nomor WhatsApp tidak valid.'],
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $identifier = $request->input('login');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // Find user by identifier
        $user = User::whereIdentifier($identifier)->first();

        if (!$user) {
            return false;
        }

        // DISABLED - Check if account is locked
        // if ($user->isAccountLocked()) {
        //     return false;
        // }

        // DISABLED - Check if user status is approved
        // if ($user->status !== 'approved') {
        //     return false;
        // }

        // DISABLED - Check if user is active
        // if (!$user->is_active) {
        //     return false;
        // }

        // Verify password
        if (!Hash::check($password, $user->password)) {
            return false;
        }

        // Log the user in
        Auth::login($user, $remember);

        return true;
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        // Simplified error message since we disabled status checks
        $message = 'Email/username/WhatsApp atau password salah.';
        
        // DISABLED - Status-specific error messages
        // $identifier = $request->input('login');
        // $user = User::whereIdentifier($identifier)->first();
        // if ($user) {
        //     if ($user->status !== 'approved') {
        //         $message = 'Akun Anda belum disetujui oleh admin. Silakan hubungi administrator.';
        //     } elseif (!$user->is_active) {
        //         $message = 'Akun Anda tidak aktif. Silakan hubungi administrator.';
        //     } elseif ($user->isAccountLocked()) {
        //         $minutes = $user->getLockoutTimeRemaining();
        //         $message = "Akun terkunci karena terlalu banyak percobaan gagal. Coba lagi dalam {$minutes} menit.";
        //     }
        // }
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
                'errors' => [
                    'login' => [$message],
                ]
            ], 422);
        }

        throw ValidationException::withMessages([
            'login' => [$message],
        ]);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the post-authentication redirect path.
     *
     * @return string
     */
    protected function redirectPath()
    {
        return '/dashboard';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Anda telah berhasil logout.'
            ]);
        }

        return redirect('/')
            ->with('success', 'Anda telah berhasil logout.');
    }

    /**
     * Get the rate limiter key for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('login')) . '|' . $request->ip();
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function checkTooManyFailedAttempts(Request $request)
    {
        // DISABLED - No rate limiting
        // if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
        //     return;
        // }

        // $seconds = RateLimiter::availableIn($this->throttleKey($request));
        // $minutes = ceil($seconds / 60);

        // $message = "Terlalu banyak percobaan login. Silakan coba lagi dalam {$minutes} menit.";

        // if ($request->expectsJson()) {
        //     throw ValidationException::withMessages([
        //         'login' => [$message],
        //     ])->status(429);
        // }

        // throw ValidationException::withMessages([
        //     'login' => [$message],
        // ]);
        
        return; // Always allow login attempts
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function incrementLoginAttempts(Request $request)
    {
        // DISABLED - No rate limiting tracking
        // RateLimiter::hit($this->throttleKey($request), 60 * 15); // 15 minutes decay
        return; // Do nothing
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function clearLoginAttempts(Request $request)
    {
        // DISABLED - No rate limiting tracking
        // RateLimiter::clear($this->throttleKey($request));
        return; // Do nothing
    }
}
