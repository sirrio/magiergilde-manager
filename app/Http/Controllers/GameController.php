<?php

namespace App\Http\Controllers;

use App\Http\Requests\Game\StoreGameRequest;
use App\Http\Requests\Game\UpdateGameRequest;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
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
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(StoreGameRequest $request): \Illuminate\Http\RedirectResponse
  {
    $game = new Game();
    $game->duration = $request->duration;
    $game->title = $request->title;
    $game->tier = $request->tier;
    $game->user_id = Auth::user()->getAuthIdentifier();
    $game->start_date = $request->start_date;
    $game->has_additional_bubble = $request->has_additional_bubble;
    $game->sessions = $request->sessions;
    $game->notes = $request->notes;
    $game->save();

    return redirect()->back();
  }

  /**
   * Display the specified resource.
   */
  public function show(Game $game)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Game $game)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UpdateGameRequest $request, Game $game): \Illuminate\Http\RedirectResponse
  {
    $game->duration = $request->duration;
    $game->start_date = $request->start_date;
    $game->title = $request->title;
    $game->tier = $request->tier;
    $game->has_additional_bubble = $request->has_additional_bubble;
    $game->sessions = $request->sessions;
    $game->notes = $request->notes;
    $game->save();

    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Game $game): \Illuminate\Http\RedirectResponse
  {
    $game->delete();

    return redirect()->back();
  }
}
