<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachSubstitution extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_coach_substitution';

    protected $primaryKey = 'id_substitution';
}
