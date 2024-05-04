<?php

namespace App\Http\Controllers;

use App\Http\Requests\Character\StoreCharacterRequest;
use App\Http\Requests\Character\UpdateCharacterRequest;
use App\Models\Character;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CharacterController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreCharacterRequest $request): \Illuminate\Http\RedirectResponse
  {
    $character = new Character();
    $character->name = $request->name;
    $character->faction = $request->faction;
    $character->notes = $request->notes;
    $character->is_filler = $request->is_filler;
    $character->dm_bubbles = $request->dm_bubbles;
    $character->dm_coins = $request->dm_coins;
    $character->bubble_shop_spend = $request->bubble_shop_spend;
    $character->user_id = Auth::user()->getAuthIdentifier();
    $character->start_tier = $request->start_tier;
    $character->external_link = $request->external_link;
    if ($request->file('avatar'))
      $character->avatar = $request->file('avatar')->store('avatars', 'public');
    $character->save();
    $character->characterClasses()->attach($request->class);

    return to_route('dashboard');
  }

  /**
   * Display the specified resource.
   */
  public function show(Character $character): \Inertia\Response
  {
    return Inertia::render('Character/Show', [
      'character' => $character
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Character $character)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateCharacterRequest $request, Character $character): \Illuminate\Http\RedirectResponse
  {
    $character->name = $request->name;
    $character->faction = $request->faction;
    $character->notes = $request->notes;
    $character->dm_bubbles = $request->dm_bubbles;
    $character->dm_coins = $request->dm_coins;
    $character->bubble_shop_spend = $request->bubble_shop_spend;
    $character->external_link = $request->external_link;
    if ($request->file('avatar'))
      $character->avatar = $request->file('avatar')->store('avatars', 'public');
    $character->save();

    $character->characterClasses()->sync($request->class);

    return to_route('dashboard');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Character $character): \Illuminate\Http\RedirectResponse
  {
    $character->adventures()->delete();
    $character->downtimes()->delete();
    $character->delete();

    return redirect()->back();
  }
}
