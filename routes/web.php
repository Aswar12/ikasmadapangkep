<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::group(['middleware' => 'guest'], function () {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    
    // Registration Routes
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    
    // Password Reset Routes
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Logout Route
Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Alumni Routes
Route::group(['middleware' => ['auth', 'role:alumni'], 'prefix' => 'alumni'], function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Dashboard\AlumniDashboardController::class, 'index'])->name('alumni.dashboard');
    
    // Profile
    Route::get('/profile', [App\Http\Controllers\Alumni\ProfileController::class, 'index'])->name('alumni.profile');
    Route::get('/profile/edit', [App\Http\Controllers\Alumni\ProfileController::class, 'edit'])->name('alumni.profile.edit');
    Route::post('/profile/update', [App\Http\Controllers\Alumni\ProfileController::class, 'update'])->name('alumni.profile.update');
    Route::post('/profile/photo', [App\Http\Controllers\Alumni\ProfileController::class, 'updateProfilePhoto'])->name('alumni.profile.photo.update');
    Route::delete('/profile/delete-photo', [App\Http\Controllers\Alumni\ProfileController::class, 'deletePhoto'])->name('alumni.profile.delete-photo');
    
    // Placeholder routes for unimplemented features
    Route::get('/events', function() { return view('alumni.placeholder', ['title' => 'Event']); })->name('alumni.events');
    Route::get('/events/{id}', function() { return view('alumni.placeholder', ['title' => 'Detail Event']); })->name('alumni.events.show');
    Route::get('/payments/create', function() { return view('alumni.placeholder', ['title' => 'Bayar Iuran']); })->name('alumni.payments.create');
    Route::get('/payments', function() { return view('alumni.placeholder', ['title' => 'Pembayaran']); })->name('alumni.payments');
    Route::get('/jobs', function() { return view('alumni.placeholder', ['title' => 'Lowongan Kerja']); })->name('alumni.jobs');
    Route::get('/jobs/{id}', function() { return view('alumni.placeholder', ['title' => 'Detail Lowongan']); })->name('alumni.jobs.show');
    
    // Job Creation Routes
    Route::get('/jobs/create', [App\Http\Controllers\Alumni\JobVacancyController::class, 'create'])->name('alumni.jobs.create');
    Route::post('/jobs', [App\Http\Controllers\Alumni\JobVacancyController::class, 'store'])->name('alumni.jobs.store');
    
    Route::get('/gallery', function() { return view('alumni.placeholder', ['title' => 'Galeri']); })->name('alumni.gallery');
    Route::get('/feedback/create', function() { return view('alumni.placeholder', ['title' => 'Kirim Saran']); })->name('alumni.feedback.create');
    Route::get('/documents', function() { return view('alumni.placeholder', ['title' => 'Dokumen']); })->name('alumni.documents');
    Route::get('/help', function() { return view('alumni.placeholder', ['title' => 'Bantuan']); })->name('alumni.help');
    Route::get('/news', function() { return view('alumni.placeholder', ['title' => 'Berita']); })->name('alumni.news');
    Route::get('/settings', function() { return view('alumni.placeholder', ['title' => 'Pengaturan']); })->name('alumni.settings');
    Route::get('/directory', [App\Http\Controllers\Alumni\AlumniDirectoryController::class, 'index'])->name('alumni.directory');
});

// API Routes for AJAX Authentication
Route::group(['prefix' => 'api', 'middleware' => 'web'], function () {
    Route::post('login', [LoginController::class, 'login'])->name('api.login');
    Route::post('logout', [LoginController::class, 'logout'])->name('api.logout');
});

// DEBUG ROUTE - TEMPORARY
Route::get('/debug-login/{identifier?}', function($identifier = null) {
    if (!$identifier) {
        return "<h2>Debug Login System</h2><p>Usage: /debug-login/[email_or_username_or_whatsapp]</p>";
    }
    
    $user = \App\Models\User::whereIdentifier($identifier)->first();
    
    $info = [
        'identifier_searched' => $identifier,
        'user_found' => $user ? 'YES' : 'NO',
    ];
    
    if ($user) {
        $info['user_data'] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'username' => $user->username,
            'whatsapp' => $user->whatsapp,
            'role' => $user->role,
            'status' => $user->status,
            'is_active' => $user->is_active,
            'account_locked' => $user->isAccountLocked(),
            'failed_attempts' => $user->failed_login_attempts,
        ];
    }
    
    // Test all possible search combinations
    $searches = [];
    
    // Test email search
    if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
        $searches['by_email'] = \App\Models\User::where('email', $identifier)->exists();
    }
    
    // Test username search
    if (preg_match('/^[a-zA-Z0-9_]{5,}$/', $identifier)) {
        $searches['by_username'] = \App\Models\User::where('username', $identifier)->exists();
    }
    
    // Test WhatsApp search
    if (preg_match('/^(\+62|62|0)[0-9]+$/', $identifier)) {
        $whatsapp = preg_replace('/[^0-9]/', '', $identifier);
        if (substr($whatsapp, 0, 3) === '628') {
            $whatsapp = '08' . substr($whatsapp, 3);
        }
        if (substr($whatsapp, 0, 2) === '62' && strlen($whatsapp) > 10) {
            $whatsapp = '08' . substr($whatsapp, 2);
        }
        $searches['by_whatsapp_normalized'] = \App\Models\User::where('whatsapp', $whatsapp)->exists();
        $searches['by_whatsapp_original'] = \App\Models\User::where('whatsapp', $identifier)->exists();
        $searches['whatsapp_normalized_to'] = $whatsapp;
    }
    
    $info['individual_searches'] = $searches;
    
    // Show all users for reference
    $info['all_users'] = \App\Models\User::select('id', 'name', 'email', 'username', 'whatsapp', 'role', 'status')->get();
    
    return '<pre>' . json_encode($info, JSON_PRETTY_PRINT) . '</pre>';
})->name('debug.login');

// DEBUG PASSWORD - TEMPORARY
Route::get('/debug-password/{identifier}/{password}', function($identifier, $password) {
    $user = \App\Models\User::whereIdentifier($identifier)->first();
    
    if (!$user) {
        return '<h2>User tidak ditemukan</h2>';
    }
    
    $passwordCheck = \Illuminate\Support\Facades\Hash::check($password, $user->password);
    
    $info = [
        'user_found' => 'YES',
        'user_name' => $user->name,
        'user_email' => $user->email,
        'user_username' => $user->username,
        'user_whatsapp' => $user->whatsapp,
        'password_provided' => $password,
        'password_hash_in_db' => $user->password,
        'password_check_result' => $passwordCheck ? 'MATCH' : 'NO MATCH',
        'account_status' => $user->status,
        'account_active' => $user->is_active,
        'account_locked' => $user->isAccountLocked(),
        'failed_attempts' => $user->failed_login_attempts,
    ];
    
    return '<pre>' . json_encode($info, JSON_PRETTY_PRINT) . '</pre>';
})->name('debug.password');

// ADMIN TOOL - APPROVE USER
Route::get('/admin/approve-user/{identifier}', function($identifier) {
    $user = \App\Models\User::whereIdentifier($identifier)->first();
    
    if (!$user) {
        return '<h2>User tidak ditemukan</h2>';
    }
    
    $user->update([
        'status' => 'approved',
        'is_active' => true
    ]);
    
    return '<h2>User berhasil diapprove!</h2><p>User: ' . $user->name . ' (' . $user->email . ') status: ' . $user->status . '</p>';
})->name('admin.approve');

// CREATE TEST USER
Route::get('/admin/create-test-user', function() {
    $user = \App\Models\User::create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'username' => 'testuser',
        'whatsapp' => '081234567890',
        'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        'role' => 'alumni',
        'status' => 'approved',
        'is_active' => true,
    ]);
    
    return '<h2>Test User Created!</h2><p>Email: test@example.com<br>Username: testuser<br>WhatsApp: 081234567890<br>Password: password123</p>';
})->name('admin.create-test');

// ADMIN TOOL - MAKE USER ADMIN
Route::get('/admin/make-admin/{identifier}', function($identifier) {
    $user = \App\Models\User::whereIdentifier($identifier)->first();
    
    if (!$user) {
        return '<h2>User tidak ditemukan</h2>';
    }
    
    $user->update([
        'role' => 'admin',
        'status' => 'approved',
        'is_active' => true
    ]);
    
    return '<h2>User berhasil dijadikan Admin!</h2>' .
           '<p><strong>Nama:</strong> ' . $user->name . '</p>' .
           '<p><strong>Email:</strong> ' . $user->email . '</p>' .
           '<p><strong>Username:</strong> ' . $user->username . '</p>' .
           '<p><strong>WhatsApp:</strong> ' . $user->whatsapp . '</p>' .
           '<p><strong>Role:</strong> ' . $user->role . '</p>' .
           '<p><strong>Status:</strong> ' . $user->status . '</p>' .
           '<p><strong>Active:</strong> ' . ($user->is_active ? 'Yes' : 'No') . '</p>';
})->name('admin.make-admin');

// TOGGLE ADMIN VERIFICATION
Route::get('/admin/toggle-verification/{status}', function($status) {
    $message = '';
    
    if ($status === 'enable') {
        $message = '<h2>🔐 Admin Verification ENABLED</h2><p>Sekarang semua user perlu disetujui admin untuk login.</p>';
    } elseif ($status === 'disable') {
        $message = '<h2>🔓 Admin Verification DISABLED</h2><p>Sekarang semua user bisa login tanpa persetujuan admin.</p>';
    } else {
        return '<h2>❌ Invalid Status</h2><p>Use: /admin/toggle-verification/enable or /admin/toggle-verification/disable</p>';
    }
    
    $message .= '<br><p><strong>Note:</strong> Untuk mengubah setting ini secara permanen, edit LoginController.php</p>';
    
    return $message;
})->name('admin.toggle-verification');

// DEBUG UPLOAD PAGE
Route::get('/debug/upload', function() {
    return view('debug.upload');
})->middleware('auth')->name('debug.upload');

// UNLOCK ALL ACCOUNTS - REMOVE ALL LOCKS
Route::get('/admin/unlock-all-accounts', function() {
    $updatedCount = \App\Models\User::where('failed_login_attempts', '>', 0)
        ->orWhereNotNull('login_locked_until')
        ->update([
            'failed_login_attempts' => 0,
            'login_locked_until' => null
        ]);
    
    // Clear rate limiter cache if using cache
    try {
        \Illuminate\Support\Facades\Cache::flush();
    } catch (Exception $e) {
        // Ignore if cache flush fails
    }
    
    return '<h2>🔓 Semua Akun Berhasil Di-unlock!</h2>' .
           '<p>Jumlah akun yang di-reset: <strong>' . $updatedCount . '</strong></p>' .
           '<p>✅ Failed login attempts direset ke 0</p>' .
           '<p>✅ Login locked until dihapus</p>' .
           '<p>✅ Rate limiter cache dibersihkan</p>' .
           '<br><p><em>Sekarang semua user bisa login tanpa batasan percobaan.</em></p>';
})->name('admin.unlock-all');

// Admin Routes
Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin'], function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    
    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/pending', [App\Http\Controllers\Admin\UserController::class, 'pending'])->name('admin.users.pending');
    Route::post('/users/{user}/approve', [App\Http\Controllers\Admin\UserController::class, 'approve'])->name('admin.users.approve');
    Route::post('/users/{user}/reject', [App\Http\Controllers\Admin\UserController::class, 'reject'])->name('admin.users.reject');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Placeholder routes for features to be implemented
    Route::get('/departments', function() { return view('admin.placeholder', ['title' => 'Departemen']); })->name('admin.departments');
    Route::get('/programs', function() { return view('admin.placeholder', ['title' => 'Program Kerja']); })->name('admin.programs');
    Route::get('/events', function() { return view('admin.placeholder', ['title' => 'Event']); })->name('admin.events');
    Route::get('/payments', function() { return view('admin.placeholder', ['title' => 'Pembayaran']); })->name('admin.payments');
    Route::get('/reports', function() { return view('admin.placeholder', ['title' => 'Laporan']); })->name('admin.reports');
    Route::get('/gallery', function() { return view('admin.placeholder', ['title' => 'Galeri']); })->name('admin.gallery');
    Route::get('/settings', function() { return view('admin.placeholder', ['title' => 'Pengaturan']); })->name('admin.settings');
});
