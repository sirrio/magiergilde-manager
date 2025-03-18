<?php

use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\Item\ShowItemShopController;
use Illuminate\Support\Facades\Route;

Route::resource('items', ItemController::class)->only([
  'index',
  'store',
  'update'
])->middleware(['auth']);

Route::get('items/shop', ShowItemShopController::class)->middleware(['auth'])->name('items.shop');
