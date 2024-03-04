<?php

namespace App\Src\CoachDomain\GoogleCalendar\Presenter;

use App\Src\CoachDomain\GoogleCalendar\Service\SessionWrapper;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;
use App\Src\UserDomain\User\Model\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;

class GenerateGoogleCalendarPresenter
{
    //construct
    private SessionRepository $sessionRepository;

    //status
    private User $coach;

    private CarbonPeriod $period;

    private Calendar $calendar;

    private Collection $events;

    public function __construct(SessionRepository $sessionRepository)
    {
        $this->sessionRepository = $sessionRepository;
    }

    public function handle(User $coach, CarbonPeriod $period): Calendar
    {

        $this->initialize($coach, $period);

        $this->createCalendar();

        $this->processEvents();

        return $this->calendar;
    }

    private function initialize(User $coach, CarbonPeriod $period)
    {

        $this->coach = $coach;
        $this->period = $period;
    }

    private function createCalendar()
    {
        $this->calendar = Calendar::create('Calendar Coach: '.$this->coach->writeFullName());
    }

    private function processEvents()
    {

        $sessions = $this->sessionRepository->obtainSessionForCoachInPeriod($this->coach, $this->period, $this->coach->timezone);

        foreach ($sessions as $session) {

            $session->load($this->sessionRepository->relations());

            $wrapper = new SessionWrapper($session);

            $event = Event::create()
                ->name($wrapper->courseName())
                ->description($wrapper->description())
                ->createdAt($wrapper->startWithTimezone())
                ->startsAt($wrapper->startWithTimezone())
                ->endsAt($wrapper->endWithTimezone());

            $this->calendar->event($event);
        }
    }
}
