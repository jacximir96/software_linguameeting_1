<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_notifications';

    protected $primaryKey = 'id_notification';
}
