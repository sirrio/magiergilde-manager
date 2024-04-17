<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $external_link
 * @property string $start_tier
 * @property integer $user_id
 * @property string $avatar
 */
class Character extends Model
{
    use HasFactory;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['adventures', 'characterClasses'];

    public function adventures(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Adventure::class);
    }

    public function characterClasses(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(CharacterClass::class);
    }
}
