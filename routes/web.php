<?php

use App\Http\Controllers\Admin\AccountantController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\AkawntController;
use App\Http\Controllers\Applicant\DashboardController as ApplicantDashboardController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AuthController;
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

// Redirect root to home
Route::get('/', function () {
    return redirect('/home');
});

// Pages
Route::get('/home', [AkawntController::class, 'home'])->name('home');
Route::get('/affiliates', [AkawntController::class, 'affiliates'])->name('affiliates');
Route::get('/reports', [AkawntController::class, 'reports'])->name('reports');

// Job Application Submission
Route::post('/apply', [ApplicationController::class, 'store'])->name('apply.store');

// Authentication Routes
Route::middleware('admin.guest')->group(function () {
    // Admin Auth
    Route::get('/admin/login', [AuthController::class, 'showAdminLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
    Route::get('/admin/register', [AuthController::class, 'showAdminRegister'])->name('admin.register');
    Route::post('/admin/register', [AuthController::class, 'adminRegister'])->name('admin.register.submit');
});

Route::middleware('guest')->group(function () {
    // Applicant Auth
    Route::get('/login', [AuthController::class, 'showApplicantLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'applicantLogin'])->name('login.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:admin')->name('logout');

// Admin Routes
Route::middleware(['auth:admin', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/applications/{application}', [AdminDashboardController::class, 'show'])->name('application.show');
    Route::post('/applications/{application}/accept', [ApplicationController::class, 'accept'])->name('application.accept');
    Route::post('/applications/{application}/decline', [ApplicationController::class, 'decline'])->name('application.decline');
    Route::post('/applications/{application}/review', [ApplicationController::class, 'review'])->name('application.review');
    Route::get('/applications/{application}/resume', [ApplicationController::class, 'downloadResume'])->name('application.download-resume');

    // Admin Management
    Route::get('/management', [AdminController::class, 'index'])->name('management.index');
    Route::get('/management/create', [AdminController::class, 'create'])->name('management.create');
    Route::post('/management', [AdminController::class, 'store'])->name('management.store');
    Route::get('/management/{admin}/edit', [AdminController::class, 'edit'])->name('management.edit');
    Route::put('/management/{admin}', [AdminController::class, 'update'])->name('management.update');
    Route::delete('/management/{admin}', [AdminController::class, 'destroy'])->name('management.destroy');

    // Accountant Management
    Route::get('/accountants', [AccountantController::class, 'index'])->name('accountants.index');
    Route::get('/accountants/create', [AccountantController::class, 'create'])->name('accountants.create');
    Route::post('/accountants', [AccountantController::class, 'store'])->name('accountants.store');
    Route::get('/accountants/{accountant}', [AccountantController::class, 'show'])->name('accountants.show');
    Route::get('/accountants/{accountant}/edit', [AccountantController::class, 'edit'])->name('accountants.edit');
    Route::put('/accountants/{accountant}', [AccountantController::class, 'update'])->name('accountants.update');
    Route::delete('/accountants/{accountant}', [AccountantController::class, 'destroy'])->name('accountants.destroy');
});

// Applicant Routes
Route::middleware(['auth', 'applicant'])->prefix('dashboard')->name('applicant.')->group(function () {
    Route::get('/', [ApplicantDashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile/edit', [ApplicantDashboardController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [ApplicantDashboardController::class, 'updateProfile'])->name('profile.update');
    Route::get('/password/change', [ApplicantDashboardController::class, 'changePassword'])->name('password.change');
    Route::put('/password', [ApplicantDashboardController::class, 'updatePassword'])->name('password.update');
});
