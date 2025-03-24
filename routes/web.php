<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\AppointmentController;

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

    // Appointment routes
    Route::middleware(['verified'])->group(function () {
        Route::get('/appointments/available', [AppointmentController::class, 'availableAppointments'])->name('appointments.available');
        Route::post('/appointments/book/{id}', [AppointmentController::class, 'bookAppointment'])->name('appointments.book');
        Route::post('/appointments/cancel', [AppointmentController::class, 'cancelAppointment'])->name('appointments.cancel');
    });

    // Admin routes
    Route::middleware('admin')->group(function () {
        // Barbers routes
        Route::get('/barbers', [BarberController::class, 'index'])->name('barbers.index');
        Route::get('/barbers/create', [BarberController::class, 'create'])->name('barbers.create');
        Route::post('/barbers', [BarberController::class, 'store'])->name('barbers.store');
        Route::get('/barbers/{id}/edit', [BarberController::class, 'edit'])->name('barbers.edit');
        Route::put('/barbers/{id}', [BarberController::class, 'update'])->name('barbers.update');
        Route::delete('/barbers/{id}', [BarberController::class, 'destroy'])->name('barbers.destroy');
        // Appointments routes
        Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
        Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
        Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
        Route::get('/appointments/{id}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
        Route::put('/appointments/{id}', [AppointmentController::class, 'update'])->name('appointments.update');
        Route::delete('/appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    });
});

// Dashboard route
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Include authentication routes
require __DIR__ . '/auth.php';
