<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property mixed $name
 * @property mixed $url
 * @property mixed $legacy_url
 * @property mixed $spell_school
 * @property mixed $spell_level
 */
class Spell extends Model
{
    use HasFactory, SoftDeletes;
}
