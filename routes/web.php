<?php

use App\Http\Controllers\AdventureController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    $characters = \App\Models\Character::where('user_id', Auth::user()->getAuthIdentifier())->get();

    return Inertia::render('Dashboard', [
        'characters' => $characters,
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/character/{character}', [CharacterController::class, 'show'])->name('character.show');
    Route::post('/character', [CharacterController::class, 'store'])->name('character.store');
    Route::post('/character/{character}', [CharacterController::class, 'update'])->name('character.update');
});

Route::middleware('auth')->group(function () {
    Route::put('/adventure', [AdventureController::class, 'store'])->name('adventure.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
