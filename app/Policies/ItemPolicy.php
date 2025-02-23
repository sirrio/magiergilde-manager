<?php

namespace App\Policies;

use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use function Symfony\Component\Translation\t;

class ItemPolicy
{
  /**
   * Determine whether the user can view any models.
   */
  public function viewAny(User $user): bool
  {
    $user = Auth::user();

    return $user->is_admin;
  }

  /**
   * Determine whether the user can view the model.
   */
  public function view(User $user, Item $item): bool
  {
    $user = Auth::user();

    return $user->is_admin;
  }

  /**
   * Determine whether the user can create models.
   */
  public function create(User $user): bool
  {
    $user = Auth::user();

    return $user->is_admin;
  }

  /**
   * Determine whether the user can update the model.
   */
  public function update(User $user, Item $item): bool
  {
    $user = Auth::user();

    return $user->is_admin;
  }

  /**
   * Determine whether the user can delete the model.
   */
  public function delete(User $user, Item $item): bool
  {
    $user = Auth::user();

    return $user->is_admin;
  }

  /**
   * Determine whether the user can restore the model.
   */
  public function restore(User $user, Item $item): bool
  {
    $user = Auth::user();

    return $user->is_admin;
  }

  /**
   * Determine whether the user can permanently delete the model.
   */
  public function forceDelete(User $user, Item $item): bool
  {
    $user = Auth::user();

    return $user->is_admin;
  }
}
