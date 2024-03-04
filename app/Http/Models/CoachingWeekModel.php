<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingWeekModel extends Model
{
    use HasFactory;

    protected $table = 'coaching_week';

    protected $primaryKey = 'id';
}