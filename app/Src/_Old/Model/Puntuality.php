<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puntuality extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_puntuality';

    protected $primaryKey = 'id_puntuality';
}
