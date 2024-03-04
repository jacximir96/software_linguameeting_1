<?php

namespace App\Src\TimeDomain\TimeHour\Repository;

use App\Src\TimeDomain\Time\Model\Time;
use App\Src\TimeDomain\TimeHour\Model\TimeHour;

class TimeHourRepository
{
    public function obtainAllFromTime(Time $time)
    {
        return TimeHour::where('time_id', $time->id)->orderBy('start')->get();
    }

    public function obtainCloserFormTime(\App\Src\Shared\Model\ValueObject\Time $time)
    {

        return TimeHour::query()
            ->where('start', '<=', $time->get())
            ->orderBy('start', 'desc')
            ->first();
    }
}
