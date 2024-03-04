<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachesCoor extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_coaches_coor';

    protected $primaryKey = 'id_user_coor';
}
