<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsFeedbacks extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_students_feedbacks';

    protected $primaryKey = 'id_feedback';
}
