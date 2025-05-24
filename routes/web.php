<?php

use App\Http\Controllers\Admin\UserApprovalController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

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

// Debug route untuk cek struktur tabel
Route::get('/check-columns', function () {
    try {
        // Cek dan tambahkan kolom yang dibutuhkan
        if (!Schema::hasColumn('users', 'last_login_ip')) {
            DB::statement('ALTER TABLE users ADD COLUMN last_login_ip VARCHAR(45) NULL AFTER last_login');
        }
        
        if (!Schema::hasColumn('users', 'registration_date')) {
            DB::statement('ALTER TABLE users ADD COLUMN registration_date TIMESTAMP NULL AFTER approved');
        }
        
        $user = App\Models\User::first();
        
        return [
            'columns_added' => 'success',
            'user_columns' => Schema::getColumnListing('users'),
            'user_data' => $user ? [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'phone' => $user->phone,
                'active' => $user->active,
                'approved' => $user->approved,
            ] : 'No user found'
        ];
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);
    
    Route::get('register', [RegisterController::class, 'create'])->name('register');
    Route::post('register', [RegisterController::class, 'store']);
    
    Route::get('forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [PasswordResetController::class, 'createReset'])->name('password.reset');
    Route::post('reset-password', [PasswordResetController::class, 'storeReset'])->name('password.update');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('approval-pending', function() {
        return view('auth.approval-pending');
    })->name('approval.pending');
    
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users/approval', [UserApprovalController::class, 'index'])->name('users.approval');
    });

// Coordinator Routes
Route::middleware(['auth', 'role:department_coordinator'])->prefix('coordinator')->name('coordinator.')->group(function () {
    // Department coordinator specific routes
});

// Sub-admin Routes
Route::middleware(['auth', 'role:sub_admin'])->prefix('sub-admin')->name('sub-admin.')->group(function () {
    // Sub-admin specific routes
});

// Admin Routes
Route::middleware(['auth', 'role:admin,sub_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Dashboard\AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Approval Routes
    Route::post('approve-user/{userId}', [\App\Http\Controllers\Dashboard\AdminDashboardController::class, 'approveUser'])->name('approve-user');
    Route::post('reject-user/{userId}', [\App\Http\Controllers\Dashboard\AdminDashboardController::class, 'rejectUser'])->name('reject-user');
    
    // User Management Routes
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    
    // Department Management Routes
    Route::resource('departments', \App\Http\Controllers\Admin\DepartmentController::class);
    
    // Program Kerja Routes
    Route::resource('programs', \App\Http\Controllers\Admin\ProgramKerjaController::class);
    
    // Event Routes
    Route::resource('events', \App\Http\Controllers\Admin\EventController::class);
    
    // Payment Routes
    Route::resource('payments', \App\Http\Controllers\Admin\PaymentController::class);
});

// Department Coordinator Routes
Route::middleware(['auth', 'role:department_coordinator'])->prefix('coordinator')->name('coordinator.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Dashboard\CoordinatorDashboardController::class, 'index'])->name('dashboard');
    Route::post('/program/{programId}/update', [\App\Http\Controllers\Dashboard\CoordinatorDashboardController::class, 'updateProgramProgress'])->name('program.update');
});

// Alumni Routes
Route::middleware(['auth', 'role:alumni'])->name('alumni.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Dashboard\AlumniDashboardController::class, 'index'])->name('dashboard');
});

// Placeholder routes for now - will be implemented later
Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', function() { return view('profile.edit'); })->name('profile.edit');
    Route::get('/payments', function() { return view('payments.index'); })->name('payments.index');
    Route::get('/events', function() { return view('events.index'); })->name('events.index');
    Route::get('/jobs', function() { return view('jobs.index'); })->name('jobs.index');
    Route::get('/gallery', function() { return view('gallery.index'); })->name('gallery.index');
    Route::get('/programs', function() { return view('programs.index'); })->name('programs.index');
});
