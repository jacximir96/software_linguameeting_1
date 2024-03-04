<?php
namespace App\Src\StudentDomain\Enrollment\Presenter\StudentRole;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use Illuminate\Support\Collection;

class SessionRegister
{

    private Collection $enrollmentSessions;

    public function __construct (Collection $enrollmentSessions){

        $this->enrollmentSessions = $enrollmentSessions;
    }

    public function get():Collection{
        return $this->enrollmentSessions;
    }

    public function hasSessionOrder (SessionOrder $sessionOrder):bool{

        foreach ($this->enrollmentSessions as $enrollmentSession){
            if ($enrollmentSession->sessionOrder()->isSame($sessionOrder)){
                return true;
            }
        }

        return false;
    }

    public function hasMakeup(EnrollmentSession $oneEnrollmentSession):bool{

        foreach ($this->enrollmentSessions as $enrollmentSession){
            if ($enrollmentSession->isRecoveryFrom($oneEnrollmentSession)){
                return true;
            }
        }

        return false;
    }

    public function extraSessions ():Collection{

        return $this->enrollmentSessions->filter(function ($enrollmentSession){
            return $enrollmentSession->isExtraSession();
        })->sortBy(function ($enrollmentSession){
            return $enrollmentSession->session_order;
        });

    }

    public function filterByOrderWithoutMakeup (SessionOrder $sessionOrder):EnrollmentSession{

        foreach ($this->enrollmentSessions as $enrollmentSession){
            if ($enrollmentSession->sessionOrder()->isSame($sessionOrder) AND !$this->hasMakeup($enrollmentSession)){
                return $enrollmentSession;
            }
        }

        throw new \Exception('Session not found');
    }
}
