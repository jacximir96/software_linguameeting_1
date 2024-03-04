<?php

namespace App\Src\TimeDomain\Time\Model;

use App\Src\TimeDomain\TimeHour\Model\TimeHour;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class Time extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    protected $table = 'time';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function hour()
    {
        return $this->hasMany(TimeHour::class, 'time_id');
    }
}
