<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesDocumentation extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_course_documentation';

    protected $primaryKey = 'id_documentation';
}
