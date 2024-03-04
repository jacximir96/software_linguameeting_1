<?php

namespace App\Src\CoachDomain\SalaryDomain\Salary\Repository;

use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use App\Src\UserDomain\User\Model\User;

class SalaryRepository
{
    public function obtainForCoach(User $coach)
    {

        return Salary::query()
            ->with('type')
            ->where('coach_id', $coach->id)
            ->first();
    }
}
