<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
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
 * Categories Route
 */
Route::apiResource('/categories', CategoryController::class);

/**
 * Get Products By Categories
 */
Route::get('/categories/{category}/products', [CategoryController::class, 'getProducts']);

/**
 * Products Route
 */
Route::apiResource('/products', ProductController::class);

/**
 * Products Search Route
 */
Route::get('/products/search/{title?}', [ProductController::class, 'search']);

/** 
 * Protected Routes
 */
Route::middleware('auth:api')->group(function () {
    
    /**
     * List Orders
     */
    Route::get('/orders', [OrderController::class, 'listOrder']);

    /**
     * Create an order
     */
    Route::post('/orders', [OrderController::class, 'createOrder']);
    
    /**
     * Show an order
     */
    Route::get('/orders/{id}', [OrderController::class, 'getOrder']);

    /**
     * Delete Order
     */
    Route::delete('/orders/{id}', [OrderController::class, 'deleteOrder']);

    /**
     * Send a mail to zobie
     */
    Route::post('/send-email', [OrderController::class, 'sendEmail']);

    /**
     * Get Current User
     */
    Route::get('/users/current', [AuthController::class, 'current']);
    
    /**
     * Logout Route
     */
    Route::post('/users/logout', [AuthController::class, 'logout']); 
});

