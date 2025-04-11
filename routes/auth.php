<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\PasswordController;

// Public routes
Route::middleware('guest')->group(function () {
    // Register view
    Route::get('registrarse', [RegisteredUserController::class, 'create'])
        ->name('register');
    // Register user
    Route::post('registrarse', [RegisteredUserController::class, 'store']);

    // Login view
    Route::get('iniciar-sesion', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    // Login user
    Route::post('iniciar-sesion', [AuthenticatedSessionController::class, 'store']);

    // Forgot password view
    Route::get('olvidaste-tu-contraseña', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    // Send password reset link
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Reset password view
    Route::get('restablecer-contraseña/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    // Reset password
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Verify email view
    Route::get('verificar-correo', EmailVerificationPromptController::class)
        ->name('verification.notice');
    // Verify email
    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');
    // Resend verification email
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    // Profile edit view
    Route::get('perfil', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    // Update profile
    Route::patch('profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    // Update password
    Route::put('password', [PasswordController::class, 'update'])
        ->name('password.update');
    // Delete profile
    Route::delete('profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    // Confirm password view
    Route::get('confirmar-contraseña', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    // Confirm password
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
