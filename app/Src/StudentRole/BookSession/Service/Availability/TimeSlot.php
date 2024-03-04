<?php

namespace App\Src\StudentRole\BookSession\Service\Availability;

use App\Src\Shared\Model\ValueObject\Time;

class TimeSlot
{
    private Time $startTime;

    private Time $endTime;

    public function __construct(Time $startTime, Time $endTime)
    {

        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    public static function buildFromTimeString(string $start, string $end): self
    {

        $startTime = new Time($start);
        $endTime = new Time($end);

        return new self($startTime, $endTime);
    }

    public function start(): Time
    {
        return $this->startTime;
    }

    public function end(): Time
    {
        return $this->endTime;
    }

    public function timeInMinutes(): int
    {
        return abs($this->timeInSeconds() / 60);
    }

    public function timeInSeconds(): int
    {
        return $this->endTime->timeInSeconds() - $this->startTime->timeInSeconds();
    }
}
