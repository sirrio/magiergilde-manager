<?php

namespace App\Http\Controllers;

use App\Http\Requests\Character\StoreCharacterRequest;
use App\Http\Requests\Character\UpdateCharacterRequest;
use App\Http\Requests\UpdateCharacterSortRequest;
use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Vtiful\Kernel\Excel;

class CharacterSortController extends Controller
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
  public function store(StoreCharacterRequest $request)
  {
  }

  /**
   * Display the specified resource.
   */
  public function show(Character $character)
  {
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
  public function update(UpdateCharacterSortRequest $request): \Illuminate\Http\RedirectResponse
  {
    $list = $request->list;
    foreach ($list as $key => $value) {
      $char = Character::find($value['id']);
      $char->position = $key;
      $char->save();
    }

    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Character $character)
  {
  }
}
