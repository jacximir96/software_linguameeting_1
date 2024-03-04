<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Service;

use App\Src\CourseDomain\CoachingWeek\Repository\CoachingWeekRepository;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;


class SessionOrderPeriodBuilder
{
    private CoachingWeekRepository $coachingWeekRepository;

    public function __construct (CoachingWeekRepository $coachingWeekRepository){

        $this->coachingWeekRepository = $coachingWeekRepository;
    }

    public function build (Enrollment $enrollment, SessionOrder $sessionOrder):SessionOrderPeriod{


        $course = $enrollment->course();

        if ($course->isFlex()){

            return new FlexSession($sessionOrder->get());
        }

        return $this->coachingWeekRepository->obtainByCourseAndOrder($course, $sessionOrder->get());
    }
}
