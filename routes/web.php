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

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('verify-email', [EmailVerificationController::class, 'notice'])->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationController::class, 'send'])->middleware(['throttle:6,1'])->name('verification.send');
    
    Route::get('approval-pending', function() {
        return view('auth.approval-pending');
    })->name('approval.pending');
    
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users/approval', [UserApprovalController::class, 'index'])->name('users.approval');
    Route::post('users/{user}/approve', [UserApprovalController::class, 'approve'])->name('users.approve');
    Route::post('users/{user}/reject', [UserApprovalController::class, 'reject'])->name('users.reject');
    Route::post('users/batch-approve', [UserApprovalController::class, 'batchApprove'])->name('users.batch-approve');
});

// Protected Routes - only for approved and verified users
Route::middleware(['auth', 'verified', 'approved'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Coordinator Routes
Route::middleware(['auth', 'verified', 'approved', 'role:department_coordinator'])->prefix('coordinator')->name('coordinator.')->group(function () {
    // Department coordinator specific routes
});

// Sub-admin Routes
Route::middleware(['auth', 'verified', 'approved', 'role:sub_admin'])->prefix('sub-admin')->name('sub-admin.')->group(function () {
    // Sub-admin specific routes
});
