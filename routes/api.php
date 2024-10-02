<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TshirtController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Auth\RegisteredUserController;

// User Authentication Routes
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

// T-shirt Routes (only for authenticated users)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/tshirts', [TshirtController::class, 'index']); // Get all t-shirts
    Route::get('/tshirts/{tshirt}', [TshirtController::class, 'show']); // Get a single t-shirt
});
Route::middleware('auth:sanctum')->group(function () {
    Route::post('cart/add/{tshirt}', [CartController::class, 'addToCart']);
    Route::get('cart', [CartController::class, 'viewCart']);
    Route::delete('cart/item/{cartItem}', [CartController::class, 'removeFromCart']);
    Route::put('cart/item/{cartItem}', [CartController::class, 'updateCartItem']);
    Route::delete('cart/clear', [CartController::class, 'clearCart']);
});

Route::middleware('auth:sanctum')->post('/cart/purchase', [PurchaseController::class, 'purchaseCart']); // Purchase cart

// Profile Routes (requires authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']); // Get user profile
    Route::put('/profile', [ProfileController::class, 'update']); // Update user profile

    // Get authenticated user information
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
});
