<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExperiencesUsers extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_experiences_users';

    protected $primaryKey = 'id';
}
