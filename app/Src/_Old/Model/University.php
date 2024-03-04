<?php

namespace App\Src\_Old\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;

    protected $connection = 'mysql_old';

    protected $table = 'lm_university';

    protected $primaryKey = 'id_university';

    public function country()
    {
        return $this->belongsTo(Country::class, 'id_country');
    }

    public function levelUniversity()
    {
        return $this->belongsTo(UniversityLevels::class, 'level');
    }

    public function timeZone()
    {
        return $this->belongsTo(TimeZones::class, 'id_zone');
    }
}
