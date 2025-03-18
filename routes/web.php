<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
  return Inertia::render('Welcome');
});

Route::get('/dashboard', function () {
  return redirect()->route('characters.index');
})->name('dashboard');

require __DIR__ . '/auth.php';
require __DIR__ . '/web/adventure.php';
require __DIR__ . '/web/ally.php';
require __DIR__ . '/web/character.php';
require __DIR__ . '/web/characterClass.php';
require __DIR__ . '/web/downtime.php';
require __DIR__ . '/web/game.php';
require __DIR__ . '/web/item.php';
require __DIR__ . '/web/user.php';
