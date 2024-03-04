<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Times extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_times';

    protected $primaryKey = 'time_id';

    public function hours()
    {
        return $this->hasMany(TimeHours::class, 'time_id');
    }
}
