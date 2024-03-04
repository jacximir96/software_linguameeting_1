<?php

namespace App\Src\CoachDomain\SalaryDomain\Incentive\Repository;

use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;
use App\Src\CoachDomain\SalaryDomain\IncentiveFrequency\Model\IncentiveFrequency;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;

class IncentiveRepository
{
    public function obtainPuntualIncentives(Month $mont, User $coach)
    {

        $period = $mont->period();

        return Incentive::query()
            ->with('type')
            ->where('coach_id', $coach->id)
            ->where('frequency_id', IncentiveFrequency::PUNTUAL_ID)
            ->whereBetween('date', [$period->getStartDate()->toDateString(), $period->getEndDate()->toDateString()])
            ->get();
    }

    public function obtainMonthlyIncentives(Month $mont, User $coach)
    {

        return Incentive::query()
            ->with('type')
            ->where('coach_id', $coach->id)
            ->where('frequency_id', IncentiveFrequency::MONTHLY_ID)
            ->get();
    }
}
