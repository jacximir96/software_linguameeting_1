<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersKeys extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_users_key';

    protected $primaryKey = 'id_user';
}
