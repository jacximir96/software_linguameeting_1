<?php

namespace App\Src\StudentRole\BookSession\Request;

trait BookSessionRequestable
{
    public function hasCoachId(): bool
    {
        return $this->has('coach_id');
    }

    public function coachId(): int|string
    {
        return $this->coach_id;
    }

    public function filterByTimeHour(): bool
    {
        return $this->has('time_hour_id');
    }

    public function timeHourIdSelected(): int
    {
        return $this->time_hour_id;
    }
}
