<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachEvaluation extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_coach_evaluation';

    protected $primaryKey = 'id_evaluation_other';
}
