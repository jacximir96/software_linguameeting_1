<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomMeetings extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_zoom_meetings';

    protected $primaryKey = 'id_zoom_meeting';
}
