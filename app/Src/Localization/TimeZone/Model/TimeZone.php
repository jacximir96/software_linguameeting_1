<?php

namespace App\Src\Localization\TimeZone\Model;

use App\Src\UniversityDomain\University\Model\University;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class TimeZone extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    const TIMEZONE_MADRID_ID = 46;
    const TIMEZONE_UTC = 'UTC';

    protected $table = 'timezone';

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function university()
    {
        return $this->hasMany(University::class);
    }

    public function convertPeriodToTimezone (CarbonPeriod $period):CarbonPeriod{

        $startDate = $period->getStartDate()->setTimezone($this->name);
        $endDate = $period->getEndDate()->setTimezone($this->name);

        return new CarbonPeriod($startDate, $endDate);

    }

    public function setPeriodToTimezone (CarbonPeriod $period):CarbonPeriod{

        $startDate = Carbon::parse($period->getStartDate()->toDateTimeString(), $this->name);
        $endDate = Carbon::parse($period->getEndDate()->toDateTimeString(), $this->name);

        return new CarbonPeriod($startDate, $endDate);

    }

    public function isSame (TimeZone $timeZone):bool{
        return $this->id == $timeZone->id;
    }

    public function simplifiedName():string{

        if ($this->name == 'America/New_York'){
            return 'EST';
        }

        return $this->name;
    }
}
