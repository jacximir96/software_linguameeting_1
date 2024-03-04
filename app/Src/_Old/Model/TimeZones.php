<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeZones extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_time_zones';

    protected $primaryKey = 'id_zone';

    public function university()
    {
        return $this->hasMany(University::class, 'id_zone');
    }
}
