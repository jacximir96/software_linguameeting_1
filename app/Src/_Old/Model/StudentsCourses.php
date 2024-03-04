<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsCourses extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_students_courses';

    protected $primaryKey = 'enroll_id';
}
