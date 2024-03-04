<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Service\Calculator;

use App\Src\CoachDomain\SalaryDomain\Salary\Service\MonthSalary;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;
use Money\Money;

/* DTO con información de una nómina de un coach */
class MonthBilling
{
    private Month $month;

    private User $coach;

    private MonthSalary $monthSalary;

    private bool $isRealPaid;

    public function __construct(Month $month, User $coach, MonthSalary $monthSalary, bool $isRealPaid = true)
    {

        $this->month = $month;
        $this->coach = $coach;
        $this->monthSalary = $monthSalary;
        $this->isRealPaid = $isRealPaid;
    }

    public function month(): Month
    {
        return $this->month;
    }

    public function coach(): User
    {
        return $this->coach;
    }

    public function monthSalary(): MonthSalary
    {
        return $this->monthSalary;
    }

    public function isRealPaid(): bool
    {
        return $this->isRealPaid;
    }

    public function isFixedSalary(): bool
    {
        return $this->monthSalary->baseSalary()->getSalary()->type->isFixed();
    }

    public function isPayerBilling(): bool
    {
        return $this->coach->coachInfo->isPayer();
    }

    public function hasDiscounts(): bool
    {
        return $this->monthSalary->baseDiscount()->hasDiscount();
    }

    public function hasIncentives(): bool
    {
        return $this->monthSalary->baseIncentive()->hasIncentive();
    }

    public function hasExtraSalary(): bool
    {
        return $this->monthSalary->extraSalary()->hasExtraSalary();
    }

    public function hours(): float
    {
        return $this->monthSalary->hours();
    }

    public function total(): Money
    {
        return $this->monthSalary->total();
    }

    public function backgroundColorInBillingFile(): string
    {
        return $this->isRealPaid() ? '#d9d9d9' : '#fff';
    }
}
