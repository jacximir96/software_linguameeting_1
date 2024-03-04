<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesCoaches extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_courses_coaches';

    protected $primaryKey = 'course_id';
}
