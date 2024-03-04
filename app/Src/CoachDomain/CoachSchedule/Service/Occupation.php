<?php
namespace App\Src\CoachDomain\CoachSchedule\Service;


class Occupation
{

    private int $availabilitySeconds;
    private int $sessionSeconds;

    public function __construct (int $availabilityInSeconds, int $secondsWithSession){
        $this->availabilitySeconds = $availabilityInSeconds;
        $this->sessionSeconds = $secondsWithSession;
    }

    public function availabilityInSeconds ():int{
        return $this->availabilitySeconds;
    }

    public function sessionInSeconds ():int{
        return $this->sessionSeconds;
    }

    public function occupationPercentage():float{

        if ($this->availabilitySeconds == 0){
            return 0;
        }

        return ($this->sessionSeconds * 100) / $this->availabilitySeconds;

    }
}
