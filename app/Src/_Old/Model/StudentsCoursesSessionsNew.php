<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsCoursesSessionsNew extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_students_courses_sessions_new';

    protected $primaryKey = 'id_student_session';

    protected $dates = ['date_select_ini', 'date_select_end'];
}
