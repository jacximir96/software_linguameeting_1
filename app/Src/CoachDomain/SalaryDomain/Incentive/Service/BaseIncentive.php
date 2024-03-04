<?php

namespace App\Src\CoachDomain\SalaryDomain\Incentive\Service;

use App\Src\TimeDomain\Month\Service\Month;
use Money\Money;

class BaseIncentive
{
    private Month $mont;

    private Money $puntualIncentive;

    private Money $monthlyIncentive;

    public function __construct(Month $mont, Money $puntualIncentive, Money $monthlyIncentive)
    {

        $this->mont = $mont;
        $this->puntualIncentive = $puntualIncentive;
        $this->monthlyIncentive = $monthlyIncentive;
    }

    public function getMont(): Month
    {
        return $this->mont;
    }

    public function getPuntualIncentive(): Money
    {
        return $this->puntualIncentive;
    }

    public function getMonthlyIncentive(): Money
    {
        return $this->monthlyIncentive;
    }

    public function hasIncentive(): bool
    {

        if ($this->puntualIncentive->getAmount() > 0) {
            return true;
        }

        if ($this->monthlyIncentive->getAmount() > 0) {
            return true;
        }

        return false;
    }

    public function total(): Money
    {
        return $this->puntualIncentive->add($this->monthlyIncentive);
    }
}
