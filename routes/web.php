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

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::get('/privacy', [HomeController::class, 'privacy'])
    ->name('privacy');

Route::middleware('auth')->group(function () {
    Route::get('/settings', [UserController::class, 'settings'])
        ->name('settings');

    Route::get('/connect', SteamController::class)
        ->name('connect');

    Route::post('delete', [UserController::class, 'delete'])
        ->name('user.delete');

    Route::post('link', [CharacterController::class, 'link'])
        ->name('character.link');

    Route::post('unlink', [CharacterController::class, 'unlink'])
        ->name('character.unlink');

    Route::post('visibility', [CharacterController::class, 'toggleVisibility'])
        ->name('character.visibility');

    Route::post('reset', [CharacterController::class, 'reset'])
        ->name('character.reset');

    Route::post('disconnect', [UserController::class, 'disconnect'])
        ->name('user.disconnect');

    Route::prefix('settings')->group(function () {
        Route::get('/{type}', function ($type) {
            return Inertia::render(sprintf('Setting/%s', ucfirst($type)), [
                'name' => 'Settings',
                'icon' => 'cog',
                'connections' => Connection::get(),
                'features' => Statistic::orderBy('name')->get()->pluck('name')
            ]);
        })->whereIn('type', [
            'account',
            'characters',
            'connections',
            'features',
            'delete'
        ]);
    });
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
