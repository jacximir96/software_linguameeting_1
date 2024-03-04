<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoomRecordings extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_zoom_recordings';

    protected $primaryKey = 'id_recording';
}
