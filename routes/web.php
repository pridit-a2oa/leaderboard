<?php

use Inertia\Inertia;
use App\Models\Statistic;
use App\Models\Connection;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SteamController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ConnectionController;
use App\Http\Controllers\UserSettingController;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/privacy', [HomeController::class, 'privacy'])
    ->name('privacy');

Route::middleware('auth')->group(function () {
    Route::post('delete', [UserController::class, 'delete'])
        ->name('user.delete');

    Route::name('connection.')
        ->prefix('connection')
        ->group(function () {
            Route::get('steam', SteamController::class)
                ->name('steam');

            Route::post('disconnect', [ConnectionController::class, 'destroy'])
                ->name('disconnect');
        }
    );

    Route::name('character.')
        ->prefix('account')
        ->group(function () {
            Route::post('link', [CharacterController::class, 'link'])
                ->name('link');

            Route::post('unlink', [CharacterController::class, 'unlink'])
                ->name('unlink');

            Route::post('visibility', [CharacterController::class, 'toggleVisibility'])
                ->name('visibility');

            Route::post('reset', [CharacterController::class, 'reset'])
                ->name('reset');
        }
    );

    Route::name('user.setting.')
        ->prefix('settings')
        ->group(function () {
            Route::get('/account', [UserSettingController::class, 'showAccount'])
                ->name('account');

            Route::get('/characters', [UserSettingController::class, 'showCharacters'])
                ->name('characters');

            Route::get('/connections', [UserSettingController::class, 'showConnections'])
                ->name('connections');

            Route::get('/features', [UserSettingController::class, 'showFeatures'])
                ->name('features');

            Route::get('/delete', [UserSettingController::class, 'showDelete'])
                ->name('delete');
        }
    );
});

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
