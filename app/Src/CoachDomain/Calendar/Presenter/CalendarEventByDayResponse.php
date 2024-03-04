<?php

namespace App\Src\CoachDomain\Calendar\Presenter;

class CalendarEventByDayResponse
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
