<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed $duration
 * @property mixed $title
 * @property mixed $user_id
 * @property mixed $start_date
 * @property mixed $has_additional_bubble
 * @property mixed $notes
 */
class Game extends Model
{
    use HasFactory;
}
