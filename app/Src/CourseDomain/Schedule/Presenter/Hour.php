<?php

namespace App\Src\CourseDomain\Schedule\Presenter;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Hour
{
    private Carbon $moment;

    private Collection $sessions;

    public function __construct(Carbon $moment)
    {

        $this->moment = $moment;

        $this->sessions = collect();
    }

    public function moment(): Carbon
    {
        return $this->moment;
    }

    public function sessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(CalendarSessionFacade $session)
    {
        $this->sessions->push($session);
    }

    public function isSameMoment(Carbon $otherMoment)
    {
        return $this->moment->toDateTimeString() == $otherMoment->toDateTimeString();
    }

    public function coaches(): Collection
    {

        $coaches = collect();

        foreach ($this->sessions as $session) {

            if (! $coaches->has($session->coach()->id)) {
                $coaches->put($session->coach()->id, $session->coach());
            }
        }

        return $coaches;
    }
}
