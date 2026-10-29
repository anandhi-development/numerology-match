<?php

use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Public & Localization
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');

// Guest Authentication
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

    // User Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reports Workflow
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports/calculate', [ReportController::class, 'calculate'])->name('reports.calculate');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::get('/reports/{report}/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
    Route::get('/reports/{report}/download', [ReportController::class, 'downloadPdf'])->name('reports.download');
    Route::post('/reports/{report}/email', [ReportController::class, 'sendEmail'])->name('reports.email');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminReportController::class, 'index'])->name('dashboard');
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/{report}', [AdminReportController::class, 'show'])->name('reports.show');
        Route::post('/reports/{report}/approve', [AdminReportController::class, 'approve'])->name('reports.approve');
        Route::post('/reports/{report}/reject', [AdminReportController::class, 'reject'])->name('reports.reject');
        Route::post('/reports/{report}/approve-email', [AdminReportController::class, 'approveAndSendEmail'])->name('reports.approve_email');
        Route::get('/users', [AdminReportController::class, 'users'])->name('users.index');
    });
});
