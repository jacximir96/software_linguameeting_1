<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_participation';

    protected $primaryKey = 'id_participation';
}
