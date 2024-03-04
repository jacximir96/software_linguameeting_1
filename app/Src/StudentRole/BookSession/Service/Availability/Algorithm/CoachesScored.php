<?php
namespace App\Src\StudentRole\BookSession\Service\Availability\Algorithm;

use Illuminate\Support\Collection;


class CoachesScored
{

    private Collection $coachScores;

    public function __construct (){
        $this->coachScores = collect();
    }

    public function coachScores ():Collection{
        return $this->coachScores;
    }

    public function countCoachScores():int{
        return $this->coachScores->count();
    }

    public function hasSorted ():bool{
        return $this->coachScores->count();
    }

    public function addCoachScore (CoachScore $coachScore){

        if ($this->coachScores->has($coachScore->coach()->id)){
            return;
        }

        $this->coachScores->put($coachScore->coach()->id, $coachScore);
    }
}
