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
    Route::get('turnos/disponibles', [AppointmentController::class, 'availableAppointments'])
        ->name('appointments.available');
    // Book appointment
    Route::post('appointments/book/{id}', [AppointmentController::class, 'bookAppointment'])
        ->name('appointments.book');
    // Cancel appointment
    Route::post('appointments/cancel', [AppointmentController::class, 'cancelAppointment'])
        ->name('appointments.cancel');

    // Appointment history view
    Route::get('turnos/historial', [AppointmentController::class, 'showHistory'])
        ->name('appointments.history');
});

// Admin routes (for authenticated users with verified email and admin role)
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    // Barber list view
    Route::get('admin/barberos', [BarberController::class, 'index'])->name('barbers.index');
    // Create barber view
    Route::get('admin/barberos/nuevo', [BarberController::class, 'create'])->name('barbers.create');
    // Store barber
    Route::post('barbers', [BarberController::class, 'store'])->name('barbers.store');
    // Edit barber view
    Route::get('admin/barberos/{barber}/editar', [BarberController::class, 'edit'])->name('barbers.edit');
    // Update barber
    Route::put('barbers/{barber}', [BarberController::class, 'update'])->name('barbers.update');
    // Delete barber
    Route::delete('barbers/{barber}', [BarberController::class, 'destroy'])->name('barbers.destroy');

    // Appointment list view
    Route::get('admin/turnos', [AppointmentController::class, 'index'])->name('appointments.index');
    // Create appointment view
    Route::get('admin/turnos/nuevo', [AppointmentController::class, 'create'])->name('appointments.create');
    // Store appointment
    Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    // Edit appointment view
    Route::get('admin/turnos/{appointment}/editar', [AppointmentController::class, 'edit'])->name('appointments.edit');
    // Update appointment
    Route::put('appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    // Delete appointment
    Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
});

// Include authentication routes
require __DIR__ . '/auth.php';
