<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Action\Command;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Repository\SessionStatusRepository;
use App\Src\StudentRole\BookSession\Service\Availability\TimeSlot;
use App\Src\UserDomain\User\Model\User;

class CreateSessionCommand
{
    private SessionStatusRepository $sessionStatusRepository;

    public function __construct(SessionStatusRepository $sessionStatusRepository)
    {
        $this->sessionStatusRepository = $sessionStatusRepository;
    }

    public function handle(Course $course, User $coach, CoachSchedule $coachSchedule, TimeSlot $timeSlot): Session
    {

        $session = new Session();
        $session->course_id = $course->id;
        $session->coach_id = $coach->id;

        $undefinedStatus = $this->sessionStatusRepository->findUnspecified();
        $session->coach_session_status_id = $undefinedStatus->id;

        $session->day = $coachSchedule->day;
        $session->start_time = $timeSlot->start()->get();
        $session->end_time = $timeSlot->end()->get();

        $session->comments = '';

        $session->save();

        return $session;
    }
}
