<?php

namespace App\Http\Controllers;

use App\Http\Requests\Character\StoreCharacterRequest;
use App\Http\Requests\Character\UpdateCharacterRequest;
use App\Models\Character;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DeletedCharacterController extends Controller
{
  /**
   * Restore the specified resource in storage.
   */
  public function restore(Character $character): \Illuminate\Http\RedirectResponse
  {
    $character->restore();

    return to_route('dashboard');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Character $character): \Illuminate\Http\RedirectResponse
  {
    $character->adventures()->withTrashed()->forceDelete();
    $character->downtimes()->withTrashed()->forceDelete();
    $character->forceDelete();

    return redirect()->back();
  }
}
