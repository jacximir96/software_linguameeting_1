<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursesSectionsNew extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_courses_sections_new';

    protected $primaryKey = 'section_id';
}
