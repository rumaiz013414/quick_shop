<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TshirtController;
use App\Http\Controllers\ProfileController;

// User Authentication Routes
Route::post('/register', [RegisteredUserController::class, 'store']); // Ensure RegisteredUserController is implemented
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/tshirts', [TshirtController::class, 'index']); // Get all t-shirts
Route::get('/tshirts/{tshirt}', [TshirtController::class, 'show']); // Get a single t-shirt
Route::post('/tshirts', [TshirtController::class, 'store']); // Create a new t-shirt
Route::put('/tshirts/{tshirt}', [TshirtController::class, 'update']); // Update a t-shirt
Route::delete('/tshirts/{tshirt}', [TshirtController::class, 'destroy']); // Delete a t-shirt

// Protected Routes (requires authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);

    // Get authenticated user information
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

});
