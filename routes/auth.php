<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\DeleteUserController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\ResendVerificationEmailController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\SteamController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    // Route::post('register', [RegisteredUserController::class, 'store'])
    //     ->middleware(HandlePrecognitiveRequests::class)
    //     ->name('register');

    // Route::post('login', [AuthenticatedSessionController::class, 'store'])
    //     ->name('login');

    // Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    //     ->name('password.email');

    // Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    //     ->name('password.reset');

    // Route::post('reset-password', [NewPasswordController::class, 'store'])
    //     ->name('password.store');

    Route::get('login', SteamController::class)
        ->middleware('throttle:10,1')
        ->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email/{token}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::get('resend-email', ResendVerificationEmailController::class)
        ->name('verification.resend');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::patch('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('delete', [DeleteUserController::class, 'create'])
        ->name('delete');

    Route::get('destroy/{token}', [DeleteUserController::class, 'destroy'])
        ->middleware('signed')
        ->name('destroy');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
