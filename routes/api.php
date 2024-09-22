<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// User Authentication Routes
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth:sanctum');

// Product Routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show'])->middleware('auth:sanctum');
Route::post('/products', [ProductController::class, 'store'])->middleware('auth:sanctum');
Route::put('/products/{product}', [ProductController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->middleware('auth:sanctum');

// Order Routes
Route::get('/orders', [OrderController::class, 'index'])->middleware('auth:sanctum');
Route::get('/orders/{order}', [OrderController::class, 'show'])->middleware('auth:sanctum');
Route::post('/orders', [OrderController::class, 'store'])->middleware('auth:sanctum');
Route::put('/orders/{order}', [OrderController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->middleware('auth:sanctum');

// Order Item Routes
Route::get('/orders/{orderId}/items', [OrderItemController::class, 'index'])->middleware('auth:sanctum');
Route::post('/order-items', [OrderItemController::class, 'store'])->middleware('auth:sanctum');
Route::get('/order-items/{orderItem}', [OrderItemController::class, 'show'])->middleware('auth:sanctum');
Route::put('/order-items/{orderItem}', [OrderItemController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/order-items/{orderItem}', [OrderItemController::class, 'destroy'])->middleware('auth:sanctum');