<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperiencesLevel extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_experiences_level';

    protected $primaryKey = 'level_id';
}
