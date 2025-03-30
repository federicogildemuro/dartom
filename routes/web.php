<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarberController;
use App\Http\Controllers\AppointmentController;

// Home view (public)
Route::get('/', fn() => view('home'))
    ->name('home');

// Appointment routes (for authenticated users with verified email)
Route::middleware(['auth', 'verified'])->group(function () {
    // Available appointments view
    Route::get('appointments/available', [AppointmentController::class, 'availableAppointments'])
        ->name('appointments.available');
    // Book appointment
    Route::post('appointments/book/{id}', [AppointmentController::class, 'bookAppointment'])
        ->name('appointments.book');
    // Cancel appointment
    Route::post('appointments/cancel', [AppointmentController::class, 'cancelAppointment'])
        ->name('appointments.cancel');
    // Appointment history view
    Route::get('appointments/history', [AppointmentController::class, 'showHistory'])
        ->name('appointments.history');
});

// Admin routes (for authenticated users with verified email and admin role)
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    // Barber routes (CRUD)
    Route::resource('barbers', BarberController::class)->except(['show']);
    // Appointment routes (CRUD)
    Route::resource('appointments', AppointmentController::class)->except(['show']);
});

// Include authentication routes
require __DIR__ . '/auth.php';
