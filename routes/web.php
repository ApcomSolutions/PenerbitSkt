<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PasswordResetController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\Admin\DashboardController;
use App\Http\Controllers\Web\Admin\CategoryController;
use App\Http\Controllers\Web\Admin\ProductController as AdminProductController;
use Illuminate\Support\Facades\Route;

// 🔐 Authentication API Routes
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'requestOTP']);
    Route::post('/verify-otp', [AuthController::class, 'verifyOTP']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    Route::post('/resend-otp', [AuthController::class, 'resendOTP']);

    // Routes requiring authentication
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

// 🛡️ Protected Admin API Routes
Route::prefix('admin')
    ->middleware(['auth:sanctum', 'admin', 'api.secure'])
    ->name('api.admin.')
    ->group(function () {
        // Categories
        Route::apiResource('categories', ProductCategoryController::class);

        // Products - Important: Specific routes before resource routes
        Route::get('products/create-form', [ProductController::class, 'getCreateFormData'])
            ->name('products.create-form');
        Route::post('products/{id}/restore', [ProductController::class, 'restore'])
            ->name('products.restore');
        Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])
            ->name('products.force-delete');
        Route::post('products/{id}/stock', [ProductController::class, 'updateStock'])
            ->name('products.update-stock');
        Route::apiResource('products', ProductController::class);
    });

// 🏠 Home route
Route::get('/', [HomeController::class, 'index'])->name('home');

// 🔐 Auth routes
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'login'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// 🔑 Reset password routes
Route::get('/forgot-password', function () {
    return view('login.forgot-password');
})->name('password.request')
    ->middleware('guest');

Route::post('/forgot-password', [PasswordResetController::class, 'sendOTP'])
    ->name('login.forgot-password')
    ->middleware('guest');

Route::get('/verify-otp', [PasswordResetController::class, 'showVerifyOtpForm'])
    ->name('login.verify-otp.form')
    ->middleware('guest');

Route::post('/verify-otp', [PasswordResetController::class, 'verifyOTP'])
    ->name('login.verify-otp')
    ->middleware('guest');

Route::post('/resend-otp', [PasswordResetController::class, 'resendOTP'])
    ->name('login.resend-otp')
    ->middleware('guest');

Route::get('/layanan', function () {
    return view('layanan');
})->name('penerbitskt.layanan');

// 🚪 Force logout utility route
Route::get('/force-logout', function() {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    session()->flush();

    // Clear cookies
    if (isset($_COOKIE['laravel_session'])) {
        setcookie('laravel_session', '', time() - 3600, '/');
    }
    if (isset($_COOKIE['XSRF-TOKEN'])) {
        setcookie('XSRF-TOKEN', '', time() - 3600, '/');
    }

    return redirect('/login')->with('message', 'Session cleared successfully');
});

// 👨‍💼 Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard/Home
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Categories
    Route::resource('categories', CategoryController::class);

    // Products - Define specific routes explicitly
    Route::get('products', [AdminProductController::class, 'index'])
        ->name('products.index');

    Route::get('products/create', [AdminProductController::class, 'create'])
        ->name('products.create');

    Route::post('products', [AdminProductController::class, 'store'])
        ->name('products.store');

    Route::get('products/trash', [AdminProductController::class, 'trash'])
        ->name('products.trash');

    Route::get('products/dump-views', [AdminProductController::class, 'dumpAllViews']);

    Route::post('products/{id}/restore', [AdminProductController::class, 'restore'])
        ->name('products.restore');

    Route::delete('products/{id}/force-delete', [AdminProductController::class, 'forceDelete'])
        ->name('products.force-delete');

    // Define ID routes with constraints - only match numeric IDs
    Route::get('products/{product}', [AdminProductController::class, 'show'])
        ->name('products.show')
        ->where('product', '[0-9]+');

    Route::get('products/{product}/edit', [AdminProductController::class, 'edit'])
        ->name('products.edit')
        ->where('product', '[0-9]+');

    Route::put('products/{product}', [AdminProductController::class, 'update'])
        ->name('products.update')
        ->where('product', '[0-9]+');

    Route::delete('products/{product}', [AdminProductController::class, 'destroy'])
        ->name('products.destroy')
        ->where('product', '[0-9]+');
});

// 📚 Product routes
Route::prefix('products')->name('products.')->group(function () {
    Route::get('/', [App\Http\Controllers\Web\ProductController::class, 'index'])
        ->name('index');

    Route::get('/{slug}', [App\Http\Controllers\Web\ProductController::class, 'show'])
        ->name('show');
});

// API Route untuk Whatsapp
Route::post('/api/generate-whatsapp-link', [App\Http\Controllers\Web\ProductController::class, 'generateWhatsAppLink'])
    ->name('api.generate-whatsapp-link');
