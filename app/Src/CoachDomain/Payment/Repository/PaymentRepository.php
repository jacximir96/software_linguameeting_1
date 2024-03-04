<?php

namespace App\Src\CoachDomain\Payment\Repository;


use App\Src\CoachDomain\Payment\Model\Payment;
use App\Src\Shared\Model\Morpheable;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;

class PaymentRepository
{
    public function findByMonthAndCoach(Month $month, User $coach)
    {

        return Payment::query()
            ->where('coach_id', $coach->id)
            ->where('year', $month->year())
            ->where('month', $month->month())
            ->first();
    }
}
