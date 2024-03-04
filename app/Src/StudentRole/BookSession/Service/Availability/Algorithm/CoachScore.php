<?php
namespace App\Src\StudentRole\BookSession\Service\Availability\Algorithm;

use App\Src\UserDomain\User\Model\User;


class CoachScore
{

    private User $coach;
    private int $score;
    private float $occupationPercentage;
    private bool $hasFreeSession;

    public function __construct (User $coach, int $score, float $occupationPercentage, bool $hasFreeSession){
        $this->coach = $coach;
        $this->score = $score;
        $this->occupationPercentage = $occupationPercentage;
        $this->hasFreeSession = $hasFreeSession;
    }

    public function coach ():User{
        return $this->coach;
    }

    public function score ():float{
        return $this->score;
    }

    public function occupationPercentage():float{
        return $this->occupationPercentage;
    }

    public function hasFreeSession ():bool{
        return $this->hasFreeSession;
    }
}
