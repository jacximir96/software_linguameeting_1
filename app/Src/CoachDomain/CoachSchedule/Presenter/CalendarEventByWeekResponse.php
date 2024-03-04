<?php

namespace App\Src\CoachDomain\CoachSchedule\Presenter;

class CalendarEventByWeekResponse
{
    private array $events;

    public function __construct(array $events)
    {

        $this->events = $events;
    }

    public function events(): array
    {
        return $this->events;
    }
}
