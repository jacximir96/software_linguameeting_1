<?php

namespace App\Src\CoachDomain\SemesterFinished\Repository;

use App\Src\CoachDomain\SemesterFinished\Model\SemesterFinished;
use App\Src\UserDomain\User\Model\User;

class SemesterFinishedRepository
{
    public function findByCoach(User $coach)
    {

        return SemesterFinished::where('coach_id', $coach->id)->first();
    }
}
