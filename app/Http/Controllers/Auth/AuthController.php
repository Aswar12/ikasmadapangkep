<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use App\Models\LoginAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string', // Bisa email atau username
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        // Cek apakah login menggunakan email atau username
        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginField => $request->login,
            'password' => $request->password
        ];

        // Catat percobaan login
        $loginAttempt = new LoginAttempt();
        $loginAttempt->ip_address = $request->ip();
        $loginAttempt->login = $request->login;
        $loginAttempt->time = time();
        $loginAttempt->success = false;
        $loginAttempt->save();

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();
            
            // Cek status aktif
            if (!$user->active) {
                Auth::logout();
                return redirect()->back()
                    ->withErrors(['login' => 'Akun Anda belum diaktivasi. Silakan cek email Anda.'])
                    ->withInput($request->except('password'));
            }

            // Update info login
            $user->last_login = now();
            $user->ip_address = $request->ip();
            $user->save();

            // Update status percobaan login
            $loginAttempt->success = true;
            $loginAttempt->save();

            // Redirect berdasarkan role
            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'sub_admin':
                    return redirect()->route('admin.dashboard');
                case 'department_coordinator':
                    return redirect()->route('department.dashboard');
                default:
                    return redirect()->route('alumni.dashboard');
            }
        }

        return redirect()->back()
            ->withErrors(['login' => 'Email/Username atau password salah'])
            ->withInput($request->except('password'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'graduation_year' => 'required|string|max:4',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'graduation_year' => $request->graduation_year,
            'phone' => $request->phone,
            'role' => 'alumni', // Default role untuk registrasi
            'active' => false, // Perlu aktivasi email
            'created_on' => now(),
            'activation_code' => md5(uniqid() . time()),
        ]);

        // Buat profil kosong
        Profile::create([
            'user_id' => $user->id,
            'graduation_year' => $request->graduation_year,
        ]);

        // Kirim email aktivasi (akan diimplementasikan nanti)
        // $user->sendActivationEmail();

        return redirect()->route('login')
            ->with('success', 'Registrasi berhasil! Silakan cek email Anda untuk aktivasi akun.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
