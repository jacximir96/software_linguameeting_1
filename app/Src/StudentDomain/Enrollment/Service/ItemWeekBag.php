<?php
namespace App\Src\StudentDomain\Enrollment\Service;

use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use Illuminate\Support\Collection;


class ItemWeekBag
{

    private Collection $coachingWeeks;

    //enrollmentSession
    private Collection $enrollmentSessions;

    public function __construct (){
        $this->coachingWeeks = collect();
        $this->enrollmentSessions = collect();
    }

    public function coachingWeeks(): Collection
    {
        return $this->coachingWeeks;
    }

    public function sessions(): Collection
    {
        return $this->enrollmentSessions;
    }

    public function addCoachingWeek (CoachingWeek $coachingWeek){
        $this->coachingWeeks->push($coachingWeek);
    }

    public function addSession(EnrollmentSession $enrollmentSession){
        $this->enrollmentSessions->push($enrollmentSession);
    }

    public function sorted ():Collection{

        $coachingWeeks = $this->coachingWeeks;

        foreach ($this->enrollmentSessions as $session){
            if ($session->isExtraSession()){
                continue;
            }
            $coachingWeeks->push($session->coachingWeek);
        }

        return $coachingWeeks->sortBy(function ($coachingWeek){
            return $coachingWeek->period()->getStartDate()->toDateString();
        });
    }

    public function hasSessionOrder(SessionOrder $sessionOrder):bool{

        foreach ($this->enrollmentSessions as $enrollmentSession){
            if ($enrollmentSession->sessionOrder()->isSame($sessionOrder)){
                return true;
            }
        }

        return false;
    }

    public function extraSessions ():Collection{

        return $this->enrollmentSessions->filter(function ($enrollmentSession){
            if ($enrollmentSession->isExtraSession()){
                return $enrollmentSession;
            }
        })->sortBy(function ($enrollmentSession){
            return $enrollmentSession->session_order;
        });

    }

    public function hasSessionOrderAsExtraSession(CoachingWeek $coachingWeek){

        foreach ($this->enrollmentSessions as $enrollmentSession){
            if ($enrollmentSession->coaching_week_id == $coachingWeek->id AND $enrollmentSession->isExtraSession()){
                return true;
            }
        }

        return false;


    }

    public function getSessionByOrder (SessionOrder $sessionOrder):EnrollmentSession{

        foreach ($this->enrollmentSessions as $enrollmentSession){
            if ($enrollmentSession->sessionOrder()->isSame($sessionOrder)){
                return $enrollmentSession;
            }
        }

        throw new \Exception(sprintf('Session %s not found', $sessionOrder->get()));

    }
}
