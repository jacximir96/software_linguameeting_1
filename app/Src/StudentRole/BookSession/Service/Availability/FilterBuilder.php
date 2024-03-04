<?php

namespace App\Src\StudentRole\BookSession\Service\Availability;

use App\Src\CoachDomain\Coach\Repository\CoachRepository;
use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Model\SessionDuration;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\Localization\Language\Model\Language;
use Carbon\Carbon;

class FilterBuilder
{
    //construct
    private CoachRepository $coachRepository;

    //status
    private Session $session;

    public function __construct(CoachRepository $coachRepository)
    {
        $this->coachRepository = $coachRepository;
    }

    public function buildForSession(Session $session): Filter
    {

        $this->session = $session;

        $coachesIds = $this->obtainCoachesIds($session->course->language);

        return $this->buildFilter($session, $coachesIds);
    }

    public function buildForSessionWithCustomCoaches(Session $session, array $coachesIds): Filter
    {

        return $this->buildFilter($session, $coachesIds);
    }

    private function obtainCoachesIds(Language $language): array
    {

        $coachesIds = $this->coachRepository->obtainCoachesIdsForLanguageAndName($language);

        foreach ($coachesIds as $key => $coachId) {
            //quitamos el coach actual de la sesión
            if ($coachId == $this->session->coach_id) {
                unset($coachesIds[$key]);
            }
        }

        return $coachesIds;
    }

    private function obtainSessionDuration(Course $course): SessionDuration
    {
        return $course->conversationPackage->sessionDuration();
    }

    private function obtainDateSlot(): DateSlot
    {
        $start = Carbon::parse($this->session->day->toDateString().' '.$this->session->start_time);
        $end = Carbon::parse($this->session->day->toDateString().' '.$this->session->end_time);

        return new DateSlot($start, $end);
    }

    private function buildFilter(Session $session, array $coachesIds): Filter
    {
        $this->session = $session;

        $sessionTimezone = $session->coach->timezone;

        $dateSlot = $this->obtainDateSlot();

        return new Filter($session->course, $sessionTimezone, $dateSlot, $coachesIds);
    }
}
