<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeHours extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_times_hours';

    protected $primaryKey = 'hour_id';

    public function time()
    {
        return $this->belongsTo(Times::class, 'time_id');
    }
}
