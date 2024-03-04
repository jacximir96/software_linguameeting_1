<?php
namespace App\Src\CourseDomain\Schedule\Presenter;

use Carbon\Carbon;
use Illuminate\Support\Collection;


class Schedule
{
    private Hours $hours;
    private string $timezoneName;

    public function __construct(Hours $hours, string $timezoneName = 'UTC')
    {
        $this->hours = $hours;
        $this->timezoneName = $timezoneName;
    }

    public function hours(): Hours
    {
        return $this->hours;
    }

    public function timezoneName():string{
        return $this->timezoneName;
    }

    public function addSession(CalendarSessionFacade $session)
    {
        $this->hours->addSession($session);
    }

    public function hoursTimeSorted(): Collection
    {

        $hours = collect();

        foreach ($this->hours->get() as $hour) {

            $momentTimezone = $hour->moment()->clone()->setTimezone($this->timezoneName);

            $key = $momentTimezone->toDateTimeString();

            if (! $hours->has($key)) {
                $hours->put($key, $momentTimezone);
            }
        }

        return $hours->sortBy(function ($moment) {
            return $moment->toTimeString();
        });
    }

    public function sessionsSameHourByHour(Carbon $moment): SessionsByHour
    {
        $sessions = collect();

        foreach ($this->hours->get() as $hourWithSessions) {

            $momentHour = $hourWithSessions->moment()->clone()->setTimezone($moment->getTimezone());

            if ($momentHour->toDatetimeString() == $moment->toDateTimeString()){
                $sessions = $sessions->merge($hourWithSessions->sessions());
            }
        }

        return new SessionsByHour($moment, $sessions);
    }

    public function coaches(): Collection
    {

        $coaches = collect();

        foreach ($this->hours->get() as $hour) {

            foreach ($hour->coaches() as $coach) {

                if (! $coaches->has($coach->id)) {
                    $coaches->put($coach->id, $coach);
                }
            }
        }

        return $coaches;
    }
}
