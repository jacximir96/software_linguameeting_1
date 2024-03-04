<?php

namespace App\Src\CoachDomain\SalaryDomain\Incentive\Service;

use App\Src\CoachDomain\SalaryDomain\Incentive\Repository\IncentiveRepository;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;
use Money\Money;

class IncentiveCalculator
{
    private IncentiveRepository $incentiveRepository;

    private LinguaMoney $linguaMoney;

    public function __construct(IncentiveRepository $incentiveRepository, LinguaMoney $linguaMoney)
    {
        $this->incentiveRepository = $incentiveRepository;
        $this->linguaMoney = $linguaMoney;
    }

    public function calculateForMonthAndCoach(Month $month, User $coach)
    {

        $puntual = $this->obtainPuntualIncentives($month, $coach);

        $monthly = $this->obtainMonthlyIncentives($month, $coach);

        return new BaseIncentive($month, $puntual, $monthly);
    }

    private function obtainPuntualIncentives(Month $month, User $coach): Money
    {

        $total = $this->linguaMoney->buildZero($coach->currency()->code);

        $incentives = $this->incentiveRepository->obtainPuntualIncentives($month, $coach);

        foreach ($incentives as $incentive) {
            $total = $total->add($incentive->value);
        }

        return $total;
    }

    private function obtainMonthlyIncentives(Month $month, User $coach): Money
    {

        $total = $this->linguaMoney->buildZero($coach->currency()->code);

        $incentives = $this->incentiveRepository->obtainMonthlyIncentives($month, $coach);

        foreach ($incentives as $incentive) {
            $total = $total->add($incentive->value);
        }

        return $total;
    }
}
