<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationsType extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_notifications_type';

    protected $primaryKey = 'id_type_notification';
}
