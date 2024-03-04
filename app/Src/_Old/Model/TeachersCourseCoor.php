<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachersCourseCoor extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_teachers_course_coor';

    protected $primaryKey = 'course_coor_id';
}
