<?php
namespace App\Src\StudentDomain\Enrollment\Service;

use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use Illuminate\Support\Collection;


class ItemFlexBag
{

    private Collection $flexSessions;

    //enrollmentSession
    private Collection $enrollmentSessions;

    public function __construct (){
        $this->flexSessions = collect();
        $this->enrollmentSessions = collect();
    }

    public function coachingWeeks(): Collection
    {
        return $this->flexSessions;
    }

    public function sessions(): Collection
    {
        return $this->enrollmentSessions;
    }

    public function addFlexSession (FlexSession $flexSession){
        $this->flexSessions->push($flexSession);
    }

    public function addSession(EnrollmentSession $enrollmentSession){
        $this->enrollmentSessions->push($enrollmentSession);
    }

    public function sorted ():Collection{

        $sessions = $this->flexSessions;

        foreach ($this->enrollmentSessions as $enrollmentSession){

            $sessionOrder = $enrollmentSession->sessionOrder();
            $flexSession = new FlexSession($sessionOrder->get());

            $sessions->push($flexSession);
        }

        return $sessions->sortBy(function ($flexSession){
            return $flexSession->number();
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

    public function getSessionByOrder (SessionOrder $sessionOrder):EnrollmentSession{

        foreach ($this->enrollmentSessions as $enrollmentSession){
            if ($enrollmentSession->sessionOrder()->isSame($sessionOrder)){
                return $enrollmentSession;
            }
        }

        throw new \Exception(sprintf('Session %s not found', $sessionOrder->get()));

    }
}
