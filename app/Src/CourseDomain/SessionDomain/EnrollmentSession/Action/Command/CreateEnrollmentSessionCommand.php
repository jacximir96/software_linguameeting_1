<?php

namespace App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action\Command;

use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\CoachingWeek\Repository\CoachingWeekRepository;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Exception\HourLimitExceeded;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionIsFull;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionIsStarted;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Repository\SessionStatusRepository;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use Carbon\Carbon;

class CreateEnrollmentSessionCommand
{
    private SessionStatusRepository $sessionStatusRepository;

    private CoachingWeekRepository $coachingWeekRepository;

    public function __construct(SessionStatusRepository $sessionStatusRepository, CoachingWeekRepository $coachingWeekRepository)
    {

        $this->sessionStatusRepository = $sessionStatusRepository;
        $this->coachingWeekRepository = $coachingWeekRepository;
    }

    public function handle(Session $session, Enrollment $enrollment, SessionOrder $sessionOrder): EnrollmentSession
    {

        $this->checkSessionIsNotFull($session);

        $this->checkSessionNotStarted($session);

        $new = new EnrollmentSession();
        $new->session_id = $session->id;
        $new->enrollment_id = $enrollment->id;

        $undefinedStatus = $this->sessionStatusRepository->findUnspecified();
        $new->session_status_id = $undefinedStatus->id;

        $coachingWeek = $this->obtainCoachingWeek($enrollment->course(), $sessionOrder);
        if ($coachingWeek) {
            $new->coaching_week_id = $coachingWeek->id;
        }

        $new->session_order = $sessionOrder->get();

        $startTime = $session->startTime();

        $new->day = $startTime->toDateString();
        $new->start_time = $startTime->toTimeString();
        $new->end_time = $session->endTime()->toTimeString();

        $new->save();

        return $new;
    }

    private function checkSessionIsNotFull (Session $session){

        $occupation = $session->occupation();

        if ($occupation->isFull()){
            throw new SessionIsFull();
        }
    }

    private function checkSessionNotStarted (Session $session){

        $hoursLimit = config('linguameeting.session.limits.scheduled_at_least_in_hours');

        $now = Carbon::now();

        $start = $session->startTime()->clone()->subHours($hoursLimit);


        if ( ! $now->lessThan($start)){
            throw new HourLimitExceeded();
        }
    }

    private function obtainCoachingWeek(Course $course, SessionOrder $sessionOrder): ?CoachingWeek
    {

        return $this->coachingWeekRepository->obtainByCourseAndOrder($course, $sessionOrder->get());

    }
}
