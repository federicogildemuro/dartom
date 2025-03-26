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
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    // Register user
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Login view
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    // Login user
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Forgot password view
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    // Send password reset link
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Reset password view
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    // Reset password
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Verify email view
    Route::get('verify-email', EmailVerificationPromptController::class)
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
    Route::get('profile', [ProfileController::class, 'edit'])
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
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    // Confirm password
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
