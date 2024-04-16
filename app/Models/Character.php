<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $class
 * @property integer $user_id
 */
class Character extends Model
{
    use HasFactory;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['adventures'];

    public function adventures(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Adventure::class);
    }
}
