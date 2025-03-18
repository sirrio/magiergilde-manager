<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class ShowItemShopController extends Controller
{
  public function __invoke(): Response
  {
    return Inertia::render('Shop/Index', [
      'items' => Item::query()->select(['id', 'name', 'cost', 'url', 'rarity', 'type'])->get(),
    ]);
  }
}
