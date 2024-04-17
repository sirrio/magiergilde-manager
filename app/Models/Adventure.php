<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $duration
 * @property integer $character_id
 * @property mixed $start_date
 * @property mixed $has_additional_bubble
 * @property mixed $notes
 */
class Adventure extends Model
{
    use HasFactory;

}
