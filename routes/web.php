<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TshirtController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TshirtSearchController;


Route::get('/', function () {
    return view('welcome');
});

// Authenticated routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // Admin dashboard route (fetching analytics)
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [ProfileController::class, 'index'])->name('users.index');
    Route::get('/users/{id}/edit', [ProfileController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}/edit', [ProfileController::class, 'adminUpdate'])->name('users.update');
    Route::delete('/users/{id}', [ProfileController::class, 'destroy'])->name('users.destroy');
    
    // T-shirt routes
    Route::get('/tshirts', [TshirtController::class, 'webindex'])->name('tshirts.index'); // Web index route
    Route::get('/tshirts/create', [TshirtController::class, 'create'])->name('tshirts.create');
    Route::post('/tshirts', [TshirtController::class, 'store'])->name('tshirts.store');
    Route::get('/tshirts/{tshirt}', [TshirtController::class, 'show'])->name('tshirts.show');
    Route::get('/tshirts/search', [TshirtSearchController::class, 'search'])->name('tshirts.search');

    
    Route::get('/tshirts/{tshirt}/edit', [TshirtController::class, 'edit'])->name('tshirts.edit');
    Route::put('/tshirts/{tshirt}', [TshirtController::class, 'update'])->name('tshirts.update');
    Route::delete('/tshirts/{tshirt}', [TshirtController::class, 'destroy'])->name('tshirts.destroy');
});

