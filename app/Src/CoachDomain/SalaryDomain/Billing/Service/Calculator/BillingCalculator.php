<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Service\Calculator;

use App\Src\CoachDomain\SalaryDomain\Discount\Service\BaseDiscount;
use App\Src\CoachDomain\SalaryDomain\Discount\Service\DiscountCalculator;
use App\Src\CoachDomain\SalaryDomain\Incentive\Service\BaseIncentive;
use App\Src\CoachDomain\SalaryDomain\Incentive\Service\IncentiveCalculator;
use App\Src\CoachDomain\SalaryDomain\Salary\Service\BaseSalary;
use App\Src\CoachDomain\SalaryDomain\Salary\Service\BaseSalaryCalculator;
use App\Src\CoachDomain\SalaryDomain\Salary\Service\ExtraSalary;
use App\Src\CoachDomain\SalaryDomain\Salary\Service\ExtraSalaryCalculator;
use App\Src\CoachDomain\SalaryDomain\Salary\Service\MonthSalary;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;

/**
 * Calcula la nómina del mes para un coach: salario base + incentivos - descuentos + extras
 */
class BillingCalculator
{
    //construct
    private BaseSalaryCalculator $baseSalaryCalculator;

    private IncentiveCalculator $incentiveCalculator;

    private DiscountCalculator $discountCalculator;

    private ExtraSalaryCalculator $extraSalaryCalculator;

    //status
    private Month $month;

    private User $coach;

    public function __construct(BaseSalaryCalculator $baseSalaryCalculator,
        IncentiveCalculator $incentiveCalculator,
        DiscountCalculator $discountCalculator,
        ExtraSalaryCalculator $extraSalaryCalculator)
    {
        $this->baseSalaryCalculator = $baseSalaryCalculator;
        $this->incentiveCalculator = $incentiveCalculator;
        $this->discountCalculator = $discountCalculator;
        $this->extraSalaryCalculator = $extraSalaryCalculator;
    }

    public function obtainForMonthAndCoach(Month $month, User $coach, bool $isRealPaid = true): MonthBilling
    {

        $this->initialize($month, $coach);

        $monthSalary = $this->obtainMonthSalary();

        return new MonthBilling($month, $coach, $monthSalary, $isRealPaid);
    }

    private function initialize(Month $month, User $coach)
    {
        $this->month = $month;
        $this->coach = $coach;
    }

    private function obtainMonthSalary(): MonthSalary
    {

        $baseSalary = $this->obtainBaseSalabry();

        $baseIncentives = $this->obtainIncentives();

        $baseDiscounts = $this->obtainDiscounts();

        $extraSalary = $this->obtainExtra();

        return new MonthSalary($baseSalary, $baseIncentives, $baseDiscounts, $extraSalary);
    }

    private function obtainBaseSalabry(): BaseSalary
    {
        return $this->baseSalaryCalculator->obtainBaseSalary($this->month, $this->coach);
    }

    private function obtainIncentives(): BaseIncentive
    {
        return $this->incentiveCalculator->calculateForMonthAndCoach($this->month, $this->coach);
    }

    private function obtainDiscounts(): BaseDiscount
    {
        return $this->discountCalculator->calculateForMonthAndCoach($this->month, $this->coach);
    }

    private function obtainExtra(): ExtraSalary
    {
        return $this->extraSalaryCalculator->obtainExtraSalary($this->month, $this->coach);
    }
}
