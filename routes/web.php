<?php

use App\Http\Controllers\Admin\AdminBusinessController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPlanController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessSettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Marketing & Information Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pricing', [HomeController::class, 'pricing'])->name('pricing');
Route::get('/features', [HomeController::class, 'features'])->name('features');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/locale/{locale}', [HomeController::class, 'setLocale'])->name('locale.set');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Business Application (Tenant Scoped & Subscription Aware)
|--------------------------------------------------------------------------
*/
Route::prefix('app')->name('app.')->middleware(['auth', 'tenant', 'subscription'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Business Profile & Tax Settings
    Route::get('/settings', [BusinessSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [BusinessSettingsController::class, 'update'])->name('settings.update');

    // Team & Roles
    Route::get('/team', [TeamController::class, 'index'])->name('team.index');
    Route::post('/team/invite', [TeamController::class, 'invite'])->name('team.invite');

    // Subscription & 14-day trial management
    Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');

    // Audit Trails
    Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit-logs.index');
});

/*
|--------------------------------------------------------------------------
| CurtissTax Super Admin Application
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'superadmin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/businesses', [AdminBusinessController::class, 'index'])->name('businesses.index');
    Route::post('/businesses/{business}/toggle-status', [AdminBusinessController::class, 'toggleStatus'])->name('businesses.toggle-status');
    Route::get('/plans', [AdminPlanController::class, 'index'])->name('plans.index');
});
