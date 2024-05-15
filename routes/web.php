<?php

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SteamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\Character\LinkController;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/privacy', function (): Response {
    return Inertia::render('Privacy', [
        'name' => 'Privacy Policy',
        'icon' => 'file'
    ]);
})->name('privacy');

Route::middleware('auth')->group(function () {
    Route::post('delete', [UserController::class, 'delete'])
        ->name('user.delete');

    Route::name('connection.')
        ->prefix('connection')
        ->group(function () {
            Route::get('steam', SteamController::class)
                ->name('steam');

            Route::delete('disconnect', [ConnectionController::class, 'destroy'])
                ->name('destroy');
        }
    );

    Route::name('character.')
        ->prefix('account')
        ->group(function () {
            Route::name('link.')
                ->group(function () {
                    Route::post('link', [LinkController::class, 'store'])
                        ->name('store');

                    Route::delete('unlink', [LinkController::class, 'destroy'])
                        ->name('destroy');
                }
            );

            Route::patch('visibility', [CharacterController::class, 'toggleVisibility'])
                ->name('visibility');

            Route::patch('reset', [CharacterController::class, 'reset'])
                ->name('reset');
        }
    );

    Route::name('user.setting.')
        ->prefix('settings')
        ->group(function () {
            Route::get('/account', [SettingController::class, 'showAccount'])
                ->name('account');

            Route::get('/features', [SettingController::class, 'showFeatures'])
                ->name('features');

            Route::get('/delete', [SettingController::class, 'showDelete'])
                ->name('delete');

            Route::middleware('verified')->group(function () {
                Route::get('/characters', [SettingController::class, 'showCharacters'])
                    ->name('characters');

                Route::get('/connections', [SettingController::class, 'showConnections'])
                    ->name('connections');
            });
        }
    );

    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
