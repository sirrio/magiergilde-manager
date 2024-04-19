<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $name
 * @property string $external_link
 * @property string $start_tier
 * @property integer $user_id
 * @property string $avatar
 * @property mixed $dm_bubbles
 * @property mixed $dm_coins
 * @property mixed $bubble_shop_spend
 */
class Character extends Model
{
  use HasFactory, SoftDeletes;

  /**
   * The relationships that should always be loaded.
   *
   * @var array
   */
  protected $with = ['adventures', 'downtimes', 'characterClasses'];

  public function adventures(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Adventure::class);
  }

  public function downtimes(): \Illuminate\Database\Eloquent\Relations\HasMany
  {
    return $this->hasMany(Downtime::class);
  }

  public function characterClasses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
  {
    return $this->belongsToMany(CharacterClass::class);
  }
}
