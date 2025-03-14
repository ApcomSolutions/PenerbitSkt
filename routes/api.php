<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductCategoryController;
use App\Http\Controllers\Api\ProductController;
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

        // Products - Important: Custom routes must be defined BEFORE the resource routes
        // to avoid routing conflicts with parameter patterns

        // Get form data needed for product creation
        Route::get('products/create-form', [ProductController::class, 'getCreateFormData'])
            ->name('products.create-form');

        // Product restoration
        Route::post('products/{id}/restore', [ProductController::class, 'restore'])
            ->name('products.restore');

        // Force delete
        Route::delete('products/{id}/force-delete', [ProductController::class, 'forceDelete'])
            ->name('products.force-delete');

        // Stock update
        Route::post('products/{id}/stock', [ProductController::class, 'updateStock'])
            ->name('products.stock');

        // After all custom routes, define the standard resource routes
        Route::apiResource('products', ProductController::class);
    });
