<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CharacterController;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');
Route::get('/privacy', [HomeController::class, 'privacy'])
    ->name('privacy');

Route::middleware('auth')->group(function () {
    Route::get('/settings', [HomeController::class, 'settings'])
        ->name('settings');

    Route::post('link', [CharacterController::class, 'link'])
        ->name('link');
});

Route::middleware('auth')->prefix('settings')->group(function () {
    Route::get('/{type}', function ($type) {
        return Inertia::render(sprintf('Setting/%s', ucfirst($type)), ['name' => 'Settings', 'icon' => 'cog']);
    })->whereIn('type', ['account', 'characters', 'connections', 'features', 'delete']);

    Route::post('delete', [UserController::class, 'delete'])
        ->name('user.delete');
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
