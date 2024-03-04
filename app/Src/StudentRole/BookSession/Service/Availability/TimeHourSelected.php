<?php
namespace App\Src\StudentRole\BookSession\Service\Availability;

use App\Src\TimeDomain\TimeHour\Model\TimeHour;
use Carbon\Carbon;


class TimeHourSelected
{
    private Carbon $date;

    private TimeHour $timeHour;

    public function __construct (Carbon $date, TimeHour $timeHour){

        $this->date = $date;
        $this->timeHour = $timeHour;
    }

    public function date ():Carbon{
        return $this->date;
    }

    public function timeHour():TimeHour{
        return $this->timeHour;
    }

    public function start ():Carbon{
        return Carbon::parse($this->date->toDateString().' '.$this->timeHour->start);
    }


}
