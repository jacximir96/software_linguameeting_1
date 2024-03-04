<?php

namespace App\Src\CoachDomain\SalaryDomain\Discount\Repository;

use App\Src\CoachDomain\SalaryDomain\Discount\Model\Discount;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;

class DiscountRepository
{
    public function obtainPuntualDiscounts(Month $mont, User $coach)
    {

        $period = $mont->period();

        return Discount::query()
            ->with('type')
            ->where('coach_id', $coach->id)
            ->whereBetween('date', [$period->getStartDate()->toDateString(), $period->getEndDate()->toDateString()])
            ->get();
    }
}
