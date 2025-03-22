<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarberController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin routes
    Route::middleware('admin')->group(function () {
        // Barbers routes
        Route::get('/barbers', [BarberController::class, 'index'])->name('barbers.index');
        Route::get('/barbers/create', [BarberController::class, 'create'])->name('barbers.create');
        Route::post('/barbers', [BarberController::class, 'store'])->name('barbers.store');
        Route::get('/barbers/{id}/edit', [BarberController::class, 'edit'])->name('barbers.edit');
        Route::put('/barbers/{id}', [BarberController::class, 'update'])->name('barbers.update');
        Route::delete('/barbers/{id}', [BarberController::class, 'destroy'])->name('barbers.destroy');
    });
});

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Include authentication routes
require __DIR__ . '/auth.php';
