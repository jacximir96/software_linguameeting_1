<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Model;

use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\Shared\Model\ValueObject\Time;
use Carbon\Carbon;


trait SessionTimeable
{

    public function createTime(string $field):Carbon
    {
        return Carbon::parse($this->day->toDateString().' '.$this->$field); //UTC by default
    }

    public function startTime(): Carbon
    {
        return $this->createTime('start_time');
    }

    public function startTimeAsTime(): Time
    {
        return new Time($this->start_time);
    }

    public function endTime(): Carbon
    {
        return $this->createTime('end_time');
    }

    public function isRunning(): bool
    {
        $start = $this->createTime('start_time');
        $end = $this->createTime('end_time');

        return Carbon::now()->between($start, $end);
    }

    public function isFuture(): bool
    {
        $start = $this->createTime('start_time');
        $now = Carbon::now();

        return $start->greaterThan($now);
    }

    public function isPast(): bool
    {
        $end = $this->createTime('end_time');
        $now = Carbon::now();

        return $now->greaterThan($end);
    }

    public function differenceInSeconds(string $startFieldTime, string $endFieldTime): int
    {

        [$h1, $m1, $s1] = explode(':', $this->$startFieldTime);
        $totalSeconds1 = $h1 * 3600 + $m1 * 60 + $s1;

        [$h2, $m2, $s2] = explode(':', $this->$endFieldTime);
        $totalSeconds2 = $h2 * 3600 + $m2 * 60 + $s2;

        return $totalSeconds2 - $totalSeconds1;

    }

    public function durationInHours(string $startFieldTime, string $endFieldTime): float
    {
        $seconds = $this->differenceInSeconds($startFieldTime, $endFieldTime);

        return $seconds / 3600;
    }

    public function dateSlot():DateSlot{

        $start = Carbon::parse($this->day.' '.$this->start_time);
        $end = Carbon::parse($this->day.' '.$this->end_time);

        return new DateSlot($start, $end);

    }

}
