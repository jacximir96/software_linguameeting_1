<?php

namespace App\Src\StudentRole\BookSession\Service\Availability;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\TimeDomain\TimeHour\Repository\TimeHourRepository;

class AvailabilityBuilder
{
    private TimeHourRepository $timeHourRepository;

    public function __construct(TimeHourRepository $timeHourRepository)
    {
        $this->timeHourRepository = $timeHourRepository;
    }

    public function buildForSession(Session $session): Availability
    {

        $scheduleSession = $session->scheduleSession();

        $availability = new Availability($scheduleSession->start());

        $start = $session->startTimeAsTime();

        $timeHour = $this->timeHourRepository->obtainCloserFormTime($start);
        $timeHour->start = $session->start_time;
        $timeHour->end = $session->end_time;

        $availabilityHour = new AvailabilitiesTimeHour($timeHour);
        $availability->add($availabilityHour);

        return $availability;
    }
}
