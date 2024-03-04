<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachDiscount extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_coach_discount';

    protected $primaryKey = 'id_discount';
}
