<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Service;

use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\Shared\Model\ValueObject\Time;
use App\Src\StudentRole\BookSession\Service\Availability\TimeSlot;
use Carbon\Carbon;

trait Schedulable
{
    public function scheduleSession(): ScheduleSession
    {

        $start = Carbon::parse($this->day->toDateString().' '.$this->start_time);
        $end = Carbon::parse($this->day->toDateString().' '.$this->end_time);

        $startTime = new Time($start->toTimeString());
        $endTime = new Time($end->toTimeString());

        $timeSlot = new TimeSlot($startTime, $endTime);

        return new ScheduleSession($start, $timeSlot);
    }

}
