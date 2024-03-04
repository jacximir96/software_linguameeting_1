<?php

namespace App\Src\CoachDomain\SalaryDomain\Salary\Service;

use App\Src\TimeDomain\Month\Service\Month;
use Money\Money;

class ExtraSalary
{
    private Month $month;

    private Money $extraSalary;

    private float $hours;

    public function __construct(Month $month, Money $extraSalary, float $hours)
    {

        $this->month = $month;
        $this->extraSalary = $extraSalary;
        $this->hours = $hours;
    }

    public function getMonth(): Month
    {
        return $this->month;
    }

    public function getExtraSalary(): Money
    {
        return $this->extraSalary;
    }

    public function getHours(): float
    {
        return $this->hours;
    }

    public function hasExtraSalary(): bool
    {
        return $this->extraSalary->getAmount() > 0;
    }
}
