<?php

use App\Http\Controllers\Admin\AdminMuteController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminWebhookController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CharacterLinkController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SteamController;
use App\Http\Controllers\UserPreferenceController;
use App\Http\Controllers\UserSettingController;
use Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Home
 */
Route::get('/', [HomeController::class, 'index'])
    ->name('home');

/**
 * Terms of Use
 */
Route::get('/terms', function (): Response {
    return Inertia::render('Terms', [
        'name' => 'Terms of Use',
        'icon' => 'file',
    ]);
})->name('terms');

/**
 * Privacy Policy
 */
Route::get('/privacy', function (): Response {
    return Inertia::render('Privacy', [
        'name' => 'Privacy Policy',
        'icon' => 'file',
    ]);
})->name('privacy');

Route::middleware('auth')->group(function () {
    /**
     * Connections
     */
    Route::name('connection.')
        ->prefix('connection')
        ->group(function () {
            Route::get('steam', SteamController::class)
                ->middleware('throttle:3,5')
                ->name('steam');

            Route::delete('disconnect', [ConnectionController::class, 'destroy'])
                ->name('destroy');
        });

    /**
     * Characters
     */
    Route::name('character.')
        ->prefix('account')
        ->group(function () {
            Route::name('link.')
                ->group(function () {
                    Route::post('link', [CharacterLinkController::class, 'store'])
                        ->name('store');

                    Route::delete('unlink', [CharacterLinkController::class, 'destroy'])
                        ->name('destroy');
                });

            Route::patch('visibility', [CharacterController::class, 'toggleVisibility'])
                ->name('visibility');

            Route::patch('reset', [CharacterController::class, 'reset'])
                ->name('reset');
        });

    /**
     * Settings
     */
    Route::name('user.setting.')
        ->prefix('settings')
        ->group(function () {
            Route::controller(UserSettingController::class)->group(function () {
                Route::get('/account', 'showAccount')->name('account');
                Route::get('/characters', 'showCharacters')->name('characters');
                Route::get('/connections', 'showConnections')->name('connections');
                Route::get('/extras', 'showExtras')->name('extras');
                Route::get('/delete', 'showDelete')->name('delete');
            });

            /** Admin */
            Route::middleware('role:admin')
                ->group(function () {
                    Route::resource('mutes', AdminMuteController::class)
                        ->only(['index', 'store', 'update', 'destroy']);

                    Route::resource('users', AdminUserController::class)
                        ->only(['index']);

                    Route::resource('webhooks', AdminWebhookController::class)
                        ->only(['index']);
                });
        });

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->middleware(HandlePrecognitiveRequests::class)
        ->name('profile.update');

    Route::patch('/preferences', [UserPreferenceController::class, 'update'])->name('preferences.update');
});

Route::webhooks('/webhook/kofi');

require __DIR__.'/auth.php';
