<?php

namespace App\Src\CourseDomain\Schedule\Presenter;

use Illuminate\Support\Collection;

class Hours
{
    private Collection $hours;

    public function __construct()
    {
        $this->hours = collect();
    }

    public function get(): Collection
    {
        return $this->hours;
    }

    public function addSession(CalendarSessionFacade $calendarSessionFacade)
    {

        $momentTime = $calendarSessionFacade->moment()->toTimeString();

        if (! $this->hours->has($momentTime)) {

            $hour = new Hour($calendarSessionFacade->moment());
            $this->hours->put($momentTime, $hour);
        }

        $hour = $this->hours->get($momentTime);
        $hour->addSession($calendarSessionFacade);
    }

    public function coaches(): Collection
    {

        $coaches = collect();

        foreach ($this->hours as $hour) {

            foreach ($hour->coaches() as $coach) {

                if (! $coaches->has($coach->id)) {
                    $coaches->put($coach->id, $coach);
                }
            }
        }

        return $coaches;
    }
}
