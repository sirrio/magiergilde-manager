<?php

use App\Exports\CharacterExport;
use App\Http\Controllers\AdventureController;
use App\Http\Controllers\AllyController;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\CharacterSortController;
use App\Http\Controllers\DeletedCharacterController;
use App\Http\Controllers\DowntimeController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/test', function () {
  return Excel::download(new CharacterExport, 'char.xlsx');
});

Route::get('/', function () {
  return Inertia::render('Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
  ]);
});

Route::get('/dashboard', function () {
  $characters = \App\Models\Character::where('user_id', Auth::user()->getAuthIdentifier())->withTrashed()->orderBy('position')->get();
  $games = \App\Models\Game::where('user_id', Auth::user()->getAuthIdentifier())->get();

  return Inertia::render('Dashboard', [
    'characters' => $characters,
    'games' => $games,
  ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::get('/character/{character}', [CharacterController::class, 'show'])->name('character.show');
  Route::post('/character', [CharacterController::class, 'store'])->name('character.store');
  Route::post('/character/{character}', [CharacterController::class, 'update'])->name('character.update');
  Route::delete('/character/{character}', [CharacterController::class, 'destroy'])->name('character.destroy');
  Route::post('/character123/sort123', [CharacterController::class, 'sort'])->name('character.sort');
});

Route::middleware('auth')->group(function () {
  Route::post('/characterSort', [CharacterSortController::class, 'update'])->name('character.sort');
});


Route::middleware('auth')->group(function () {
  Route::put('/ally', [AllyController::class, 'store'])->name('ally.store');
  Route::delete('/ally/{ally}', [AllyController::class, 'destroy'])->name('ally.destroy');
});

Route::middleware('auth')->group(function () {
  Route::patch('/deletedCharacter/{character}', [DeletedCharacterController::class, 'restore'])->withTrashed()->name('deletedCharacter.restore');
  Route::delete('/deletedCharacter/{character}', [DeletedCharacterController::class, 'destroy'])->withTrashed()->name('deletedCharacter.destroy');
});

Route::middleware('auth')->group(function () {
  Route::put('/adventure', [AdventureController::class, 'store'])->name('adventure.store');
  Route::patch('/adventure/{adventure}', [AdventureController::class, 'update'])->name('adventure.update');
  Route::delete('/adventure/{adventure}', [AdventureController::class, 'destroy'])->name('adventure.destroy');
});

Route::middleware('auth')->group(function () {
  Route::put('/game', [GameController::class, 'store'])->name('game.store');
  Route::patch('/game/{game}', [GameController::class, 'update'])->name('game.update');
  Route::delete('/game/{game}', [GameController::class, 'destroy'])->name('game.destroy');
});

Route::middleware('auth')->group(function () {
  Route::put('/downtime', [DowntimeController::class, 'store'])->name('downtime.store');
  Route::patch('/downtime/{downtime}', [DowntimeController::class, 'update'])->name('downtime.update');
  Route::delete('/downtime/{downtime}', [DowntimeController::class, 'destroy'])->name('downtime.destroy');
});

Route::middleware('auth')->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
