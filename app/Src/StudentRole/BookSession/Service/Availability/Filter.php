<?php

namespace App\Src\StudentRole\BookSession\Service\Availability;

use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Course\Model\SessionDuration;
use App\Src\Localization\TimeZone\Model\TimeZone;

class Filter
{

    private Course $course;

    private TimeZone $timeZone;

    private DateSlot $dateSlot;

    private array $coachesIds;

    public function __construct(Course $course,  TimeZone $timeZone, DateSlot $dateSlot, array $coachesIds, )
    {
        $this->course = $course;
        $this->timeZone = $timeZone;
        $this->dateSlot = $dateSlot;
        $this->coachesIds = $coachesIds;
    }

    public function course():Course{
        return $this->course;
    }

    public function sessionDuration(): SessionDuration
    {
        return $this->course->conversationPackage->sessionDuration();
    }

    public function timeZone(): TimeZone
    {
        return $this->timeZone;
    }

    public function dateSlot(): DateSlot
    {
        return $this->dateSlot;
    }

    public function coachesIds(): array
    {
        return $this->coachesIds;
    }
}
