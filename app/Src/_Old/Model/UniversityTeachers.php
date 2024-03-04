<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UniversityTeachers extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_university_teachers';

    protected $primaryKey = 'id_university';
}
