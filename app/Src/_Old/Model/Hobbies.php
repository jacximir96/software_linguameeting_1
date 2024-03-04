<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobbies extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_hobbies_users';

    protected $primaryKey = 'id_hobby';
}
