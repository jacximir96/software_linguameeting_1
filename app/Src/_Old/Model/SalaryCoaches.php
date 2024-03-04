<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaryCoaches extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_salary_coaches';

    protected $primaryKey = 'id_salary_coach';
}
