<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experiences extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_experiences';

    protected $primaryKey = 'id_experience';
}
