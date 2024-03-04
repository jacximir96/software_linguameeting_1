<?php

namespace App\Src\CourseDomain\Schedule\Presenter;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class SessionsByHour
{
    private Carbon $moment;

    private Collection $sessions;

    public function __construct(Carbon $moment, Collection $sessions)
    {

        $this->moment = $moment;
        $this->sessions = $sessions;
    }

    public function sessionsOnDay(int $weekDay): Collection
    {

        $sessionsOnDay = collect();

        foreach ($this->sessions as $session) {

            if ($session->moment()->isDayOfWeek($weekDay)) {
                $sessionsOnDay->push($session);
            }
        }

        return $sessionsOnDay;
    }
}
