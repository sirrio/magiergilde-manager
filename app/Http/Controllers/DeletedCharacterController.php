<?php

namespace App\Http\Controllers;

use App\Http\Requests\Character\StoreCharacterRequest;
use App\Http\Requests\Character\UpdateCharacterRequest;
use App\Models\Adventure;
use App\Models\Character;
use App\Models\Downtime;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DeletedCharacterController extends Controller
{
  /**
   * Restore the specified resource in storage.
   */
  public function restore(Character $character): \Illuminate\Http\RedirectResponse
  {
    $character->adventures()->withTrashed()->each(function (Adventure $adventure) {
      $adventure->restore();
    });
    $character->downtimes()->withTrashed()->each(function (Downtime $downtime) {
      $downtime->restore();
    });
    $character->restore();

    return to_route('characters');
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
