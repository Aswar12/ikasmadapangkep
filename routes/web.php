<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminFinanceController;
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
    
    // Payments
    Route::get('/payments', [App\Http\Controllers\Alumni\PaymentController::class, 'index'])->name('alumni.payments');
    Route::get('/payments/create', [App\Http\Controllers\Alumni\PaymentController::class, 'create'])->name('alumni.payments.create');
    Route::post('/payments', [App\Http\Controllers\Alumni\PaymentController::class, 'store'])->name('alumni.payments.store');
    Route::get('/payments/{payment}', [App\Http\Controllers\Alumni\PaymentController::class, 'show'])->name('alumni.payments.show');
    Route::get('/payments/{payment}/download-proof', [App\Http\Controllers\Alumni\PaymentController::class, 'downloadProof'])->name('alumni.payments.download-proof');
    Route::get('/payments/{payment}/proof', [App\Http\Controllers\Alumni\PaymentController::class, 'showProof'])->name('alumni.payments.proof');
    
    // Placeholder routes for unimplemented features
    Route::get('/events', function() { return view('alumni.placeholder', ['title' => 'Event']); })->name('alumni.events');
    Route::get('/events/{id}', function() { return view('alumni.placeholder', ['title' => 'Detail Event']); })->name('alumni.events.show');
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


// Admin Routes
Route::group(['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin'], function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\Dashboard\AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // User Management
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/create', [App\Http\Controllers\Admin\UserController::class, 'create'])->name('admin.users.create');
    Route::get('/users/pending', [App\Http\Controllers\Admin\UserController::class, 'pending'])->name('admin.users.pending');
    Route::get('/users/coordinators', [App\Http\Controllers\Admin\UserController::class, 'coordinators'])->name('admin.users.coordinators');
    Route::get('/users/departments', [App\Http\Controllers\Admin\UserController::class, 'departments'])->name('admin.users.departments');
    Route::post('/users/{user}/approve', [App\Http\Controllers\Admin\UserController::class, 'approve'])->name('admin.users.approve');
    Route::post('/users/{user}/reject', [App\Http\Controllers\Admin\UserController::class, 'reject'])->name('admin.users.reject');
    Route::post('/users/bulk-approve', [App\Http\Controllers\Admin\UserController::class, 'bulkApprove'])->name('admin.users.bulkApprove');
    Route::post('/users/bulk-reject', [App\Http\Controllers\Admin\UserController::class, 'bulkReject'])->name('admin.users.bulkReject');
    Route::post('/users/bulk-change-role', [App\Http\Controllers\Admin\UserController::class, 'bulkChangeRole'])->name('admin.users.bulkChangeRole');
    Route::post('/users/bulk-send-email', [App\Http\Controllers\Admin\UserController::class, 'bulkSendEmail'])->name('admin.users.bulkSendEmail');
    Route::post('/users/bulk-delete', [App\Http\Controllers\Admin\UserController::class, 'bulkDelete'])->name('admin.users.bulkDelete');
    Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    
    // Department management routes that were previously pointing to UserController
    // Route::post('/departments', [App\Http\Controllers\Admin\UserController::class, 'storeDepartment'])->name('admin.departments.store'); // Now handled by DepartmentController
    // Route::put('/departments/{department}', [App\Http\Controllers\Admin\UserController::class, 'updateDepartment'])->name('admin.departments.update'); // Now handled by DepartmentController
    Route::put('/departments/{department}/assign-coordinator', [App\Http\Controllers\Admin\UserController::class, 'assignCoordinator'])->name('admin.departments.assign-coordinator'); // This should likely be DepartmentController too, but is out of scope for this task
    // Route::delete('/departments/{department}', [App\Http\Controllers\Admin\UserController::class, 'destroyDepartment'])->name('admin.departments.destroy'); // Now handled by DepartmentController

    // Department Management (using DepartmentController)
    Route::get('/departments', [App\Http\Controllers\Admin\DepartmentController::class, 'index'])->name('admin.departments.index');
    Route::get('/departments/create', [App\Http\Controllers\Admin\DepartmentController::class, 'create'])->name('admin.departments.create');
    Route::post('/departments', [App\Http\Controllers\Admin\DepartmentController::class, 'store'])->name('admin.departments.store');
    Route::get('/departments/{department}/edit', [App\Http\Controllers\Admin\DepartmentController::class, 'edit'])->name('admin.departments.edit');
    Route::put('/departments/{department}', [App\Http\Controllers\Admin\DepartmentController::class, 'update'])->name('admin.departments.update');
    Route::delete('/departments/{department}', [App\Http\Controllers\Admin\DepartmentController::class, 'destroy'])->name('admin.departments.destroy');
    Route::get('/departments/{department}', function() { return view('admin.placeholder', ['title' => 'Detail Departemen']); })->name('admin.departments.show');
    
    // Program Kerja Management
    // Program Kerja Management
    Route::get('/program-kerja', [App\Http\Controllers\Admin\ProgramKerjaController::class, 'index'])->name('admin.program-kerja.index');
    Route::get('/program-kerja/create', [App\Http\Controllers\Admin\ProgramKerjaController::class, 'create'])->name('admin.program-kerja.create');
    Route::post('/program-kerja', [App\Http\Controllers\Admin\ProgramKerjaController::class, 'store'])->name('admin.program-kerja.store');
    Route::get('/program-kerja/{programKerja}/edit', [App\Http\Controllers\Admin\ProgramKerjaController::class, 'edit'])->name('admin.program-kerja.edit');
    Route::put('/program-kerja/{programKerja}', [App\Http\Controllers\Admin\ProgramKerjaController::class, 'update'])->name('admin.program-kerja.update');
    Route::delete('/program-kerja/{programKerja}', [App\Http\Controllers\Admin\ProgramKerjaController::class, 'destroy'])->name('admin.program-kerja.destroy');
    // Consider adding PATCH as well if partial updates are desired: Route::patch('/program-kerja/{programKerja}', [App\Http\Controllers\Admin\ProgramKerjaController::class, 'update']);
    
    // Event Management
    Route::get('/events', function() { return view('admin.placeholder', ['title' => 'Event']); })->name('admin.events.index');
    Route::get('/events/create', function() { return view('admin.placeholder', ['title' => 'Buat Event']); })->name('admin.events.create');
    
    // Job Management
    Route::get('/jobs', function() { return view('admin.placeholder', ['title' => 'Lowongan Kerja']); })->name('admin.jobs.index');
    // Payments
    Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('admin.payments');
    Route::get('/payments/report', [App\Http\Controllers\Admin\PaymentController::class, 'report'])->name('admin.payments.report');
    Route::get('/payments/{payment}', [App\Http\Controllers\Admin\PaymentController::class, 'show'])->name('admin.payments.show');
    Route::post('/payments/{payment}/approve', [App\Http\Controllers\Admin\PaymentController::class, 'approve'])->name('admin.payments.approve');
    Route::post('/payments/{payment}/reject', [App\Http\Controllers\Admin\PaymentController::class, 'reject'])->name('admin.payments.reject');
    Route::post('/payments/bulk-approve', [App\Http\Controllers\Admin\PaymentController::class, 'bulkApprove'])->name('admin.payments.bulk-approve');
    // Finance Management
    Route::get('/finance', function() { return view('admin.placeholder', ['title' => 'Keuangan']); })->name('admin.finance.index');
    Route::get('/finance/dues', [AdminFinanceController::class, 'duesDashboard'])->name('admin.finance.dues');
    Route::get('/finance/cashflow', function() { return view('admin.placeholder', ['title' => 'Arus Kas']); })->name('admin.finance.cashflow');
    Route::get('/finance/reports', function() { return view('admin.placeholder', ['title' => 'Laporan Keuangan']); })->name('admin.finance.reports');
    
    // Gallery Management
    Route::get('/gallery', function() { return view('admin.placeholder', ['title' => 'Galeri']); })->name('admin.gallery.index');
    
    // Reports & Analytics
    Route::get('/reports', function() { return view('admin.placeholder', ['title' => 'Laporan']); })->name('admin.reports.index');
    Route::get('/reports/export', function() { return view('admin.placeholder', ['title' => 'Export Data']); })->name('admin.reports.export');
    
    // Settings
    Route::get('/settings', function() { return view('admin.placeholder', ['title' => 'Pengaturan']); })->name('admin.settings.index');
});

// Coordinator Routes
Route::group(['middleware' => ['auth', 'role:coordinator'], 'prefix' => 'coordinator', 'as' => 'coordinator.'], function () {
    // Dashboard (example, can be added later)
    // Route::get('/dashboard', [App\Http\Controllers\Dashboard\CoordinatorDashboardController::class, 'index'])->name('dashboard');

    // Program Kerja Management for Coordinator
    Route::get('/program-kerja', [App\Http\Controllers\Coordinator\ProgramKerjaController::class, 'index'])->name('program-kerja.index');
    Route::get('/program-kerja/create', [App\Http\Controllers\Coordinator\ProgramKerjaController::class, 'create'])->name('program-kerja.create');
    Route::post('/program-kerja', [App\Http\Controllers\Coordinator\ProgramKerjaController::class, 'store'])->name('program-kerja.store');
    Route::get('/program-kerja/{programKerja}/edit', [App\Http\Controllers\Coordinator\ProgramKerjaController::class, 'edit'])->name('program-kerja.edit');
    Route::put('/program-kerja/{programKerja}', [App\Http\Controllers\Coordinator\ProgramKerjaController::class, 'update'])->name('program-kerja.update');
    Route::delete('/program-kerja/{programKerja}', [App\Http\Controllers\Coordinator\ProgramKerjaController::class, 'destroy'])->name('program-kerja.destroy');
    Route::post('/program-kerja/{programKerja}/store-update', [App\Http\Controllers\Coordinator\ProgramKerjaController::class, 'storeUpdate'])->name('program-kerja.storeUpdate');
    // Add other Program Kerja routes for coordinator here (e.g., show, updates)
});
