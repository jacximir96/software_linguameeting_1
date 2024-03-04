<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachesCoorSalary extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_coaches_coor_salary';

    protected $primaryKey = 'id_user_coach';
}
