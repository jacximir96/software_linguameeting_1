<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Service;


use App\Src\StudentRole\BookSession\Service\Availability\TimeSlot;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ScheduleSession
{
    private Carbon $date;

    private TimeSlot $timeSlot;

    public function __construct(Carbon $date, TimeSlot $timeSlot)
    {
        $this->date = $date;
        $this->timeSlot = $timeSlot;
    }

    public function date(): Carbon
    {
        return $this->date;
    }

    public function start(): Carbon
    {
        return Carbon::parse($this->date->toDateString().' '.$this->timeSlot->start()->get());
    }

    public function end(): Carbon
    {
        return Carbon::parse($this->date->toDateString().' '.$this->timeSlot->end()->get());
    }

    public function timeSlot(): TimeSlot
    {
        return $this->timeSlot;
    }

    public function isPast ():bool{

        $start = $this->start();

        $now = Carbon::now();

        return $now->greaterThan($start);
    }

    public function isFuture ():bool{

        $start = $this->start();

        $now = Carbon::now();

        return $now->lessThan($start);
    }

    public function isToday():bool{

        $today = Carbon::now()->toDateString();

        return $this->start()->toDateString() == $today;
    }

    public function print(): string
    {
        return $this->date->format('m/d/Y').' '.$this->timeSlot->start()->convertTo12HourFormat();
    }

    public function period ():CarbonPeriod{
        return CarbonPeriod::create($this->start(), $this->end());
    }
}
