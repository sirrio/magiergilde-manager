<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Models\Item;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;

class ItemController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $items = Item::query()->select(['id', 'name', 'cost', 'url', 'rarity', 'type'])->get();

    return Inertia::render('Item/Index', [
      'items' => $items,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreItemRequest $request): RedirectResponse
  {
    $item = new Item();

    $item->name = $request->name;
    $item->cost = $request->cost;
    $item->url = $request->url;
    $item->rarity = $request->rarity;
    $item->type = $request->type;
    $item->save();

    return redirect()->back();
  }

  /**
   * Display the specified resource.
   */
  public function show(Item $item)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Item $item)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateItemRequest $request, Item $item): RedirectResponse
  {
    $item->name = $request->name;
    $item->cost = $request->cost;
    $item->url = $request->url;
    $item->rarity = $request->rarity;
    $item->type = $request->type;
    $item->save();

    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Item $item)
  {
    //
  }
}
