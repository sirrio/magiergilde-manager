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
}
