<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Presenter;


use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;

class NextSessionsPresenter
{

    private SessionRepository $sessionRepository;

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    public function __construct (SessionRepository $sessionRepository, EnrollmentSessionRepository $enrollmentSessionRepository){

        $this->sessionRepository = $sessionRepository;
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
    }


    public function handle(EnrollmentSession $enrollmentSession):NextSessions{

        $nextSessions = new NextSessions();

        $course = $enrollmentSession->enrollment->course();
        $nextWeeks = $course->obtainCoachingWeekWithoutMakeUpGreatherThanSession($enrollmentSession->sessionOrder());

        $scheduleSession = $enrollmentSession->scheduleSession();

        foreach ($nextWeeks as $nextWeek){

            $enrollmentSessionExisting = $this->enrollmentSessionRepository->obtainByEnrollmentAndSessionOrder($enrollmentSession->enrollment, $nextWeek->sessionOrderObject());

            if ($enrollmentSessionExisting){
                $next = new NextSessionExisting($enrollmentSessionExisting->session);
                $nextSessions->addNextSessionExisting($next);
                continue;
            }

            $period = $nextWeek->period();

            foreach ($period as $date){

                if ($date->dayOfWeek == $scheduleSession->start()->dayOfWeekIso){

                    $session = $this->sessionRepository->obtainSessionByCoachCourseAndDate($enrollmentSession->session->coach, $course, $date);

                    if($session){
                        $next = new NextSessionAvailable($nextWeek, $session);
                        $nextSessions->addNextSessionAvailable($next);
                    }
                    else{
                        $next = new NextSessionNotAvailable($nextWeek);
                        $nextSessions->addNextSessionNotAvailable($next);
                    }
                }
            }
        }

        return $nextSessions;
    }
}
