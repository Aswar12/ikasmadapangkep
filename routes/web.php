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
    
    // Tambahkan placeholder route sementara untuk rute yang belum diimplementasikan
    Route::get('/events', function() { return view('alumni.placeholder', ['title' => 'Event']); })->name('alumni.events');
    Route::get('/events/{id}', function() { return view('alumni.placeholder', ['title' => 'Detail Event']); })->name('alumni.events.show');
    Route::get('/payments/create', function() { return view('alumni.placeholder', ['title' => 'Bayar Iuran']); })->name('alumni.payments.create');
    Route::get('/jobs', function() { return view('alumni.placeholder', ['title' => 'Lowongan Kerja']); })->name('alumni.jobs');
    Route::get('/jobs/{id}', function() { return view('alumni.placeholder', ['title' => 'Detail Lowongan']); })->name('alumni.jobs.show');
    
    // Job Creation Routes
    Route::get('/jobs/create', [App\Http\Controllers\Alumni\JobVacancyController::class, 'create'])->name('alumni.jobs.create');
    Route::post('/jobs', [App\Http\Controllers\Alumni\JobVacancyController::class, 'store'])->name('alumni.jobs.store');
    Route::get('/gallery', function() { return view('alumni.placeholder', ['title' => 'Galeri']); })->name('alumni.gallery');
    Route::get('/feedback/create', function() { return view('alumni.placeholder', ['title' => 'Kirim Saran']); })->name('alumni.feedback.create');
});

// API Routes for AJAX Authentication
Route::group(['prefix' => 'api', 'middleware' => 'web'], function () {
    Route::post('login', [LoginController::class, 'login'])->name('api.login');
    Route::post('logout', [LoginController::class, 'logout'])->name('api.logout');
});
