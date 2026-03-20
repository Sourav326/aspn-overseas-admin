<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CandidateController;
use App\Http\Controllers\Admin\ClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Guest routes
Route::middleware('guest')->group(function () {
    // User authentication
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    
    // Password Reset Routes
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
    
    // Admin authentication
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminLoginController::class, 'login']);
    });
});

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    // User logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // User dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Admin routes
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    });
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
// User Management Routes
    Route::resource('users', UserController::class);
    // Export Routes
    Route::get('/users/export/excel', [UserController::class, 'exportExcel'])->name('users.export.excel');
    Route::get('/users/export/csv', [UserController::class, 'exportCsv'])->name('users.export.csv');
    Route::get('/users/export/pdf', [UserController::class, 'exportPdf'])->name('users.export.pdf');
    Route::get('/users/export/modal', [UserController::class, 'showExportModal'])->name('users.export.modal');
    Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
});


Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // ... existing routes ...
    
    // Candidate Management Routes
    Route::resource('candidates', CandidateController::class);
    Route::post('/candidates/{id}/verify', [CandidateController::class, 'verify'])->name('candidates.verify');
    Route::get('/candidates/{id}/download-resume', [CandidateController::class, 'downloadResume'])->name('candidates.download-resume');
    
    // Candidate Export Routes
    Route::get('/candidates/export/excel', [CandidateController::class, 'exportExcel'])->name('candidates.export.excel');
    Route::get('/candidates/export/csv', [CandidateController::class, 'exportCsv'])->name('candidates.export.csv');
    Route::get('/candidates/export/pdf', [CandidateController::class, 'exportPdf'])->name('candidates.export.pdf');
    
    // Client Management
    Route::resource('clients', ClientController::class);
    Route::post('/clients/{id}/verify', [ClientController::class, 'verify'])->name('clients.verify');

     // Client Export Routes
    Route::get('/clients/export/excel', [ClientController::class, 'exportExcel'])->name('clients.export.excel');
    Route::get('/clients/export/csv', [ClientController::class, 'exportCsv'])->name('clients.export.csv');
    Route::get('/clients/export/pdf', [ClientController::class, 'exportPdf'])->name('clients.export.pdf');
});