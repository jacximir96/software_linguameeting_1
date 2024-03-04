<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeachersAssistantSection extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_teachers_assistant_section';

    protected $primaryKey = 'teacher_assistant_id';
}
