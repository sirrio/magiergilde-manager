<?php

namespace App\Http\Controllers;

use App\Models\Adventure;
use App\Models\Character;
use App\Http\Requests\StoreCharacterRequest;
use App\Http\Requests\UpdateCharacterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use function Termwind\renderUsing;

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
    $character->characterClasses()->detach();
    $character->delete();

    return redirect()->back();
  }
}
