<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

/**
 * Register Route
 */
Route::post('/users/register', [AuthController::class, 'register'])->name('register');

/**
 * Login Route
 */
Route::post('/users/login', [AuthController::class, 'login'])->name('login');

/**
 * Reset Password
 */
Route::get('/users/password/reset/{token?} ', [AuthController::class, 'showResetForm'])->name('password.reset');

/**
 * Forgot Password
 */
Route::post('/users/password/email', [AuthController::class, 'forgotPassword'])->name('password.email');

/**
 * Reset Password
 */
Route::post('/users/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

/** 
 * Protected Routes
 */
Route::middleware('auth:api')->group(function () {

    Route::apiResource('/products', ProductController::class);
    
    /**
     * Get Current User
     */
    Route::get('/users/current', [AuthController::class, 'current']);
    
    /**
     * Logout Route
     */
    Route::post('/users/logout', [AuthController::class, 'logout']); 
});

