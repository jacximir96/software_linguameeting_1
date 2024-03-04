<?php

namespace App\Src\CoachDomain\SalaryDomain\Salary\Service;

use App\Src\CoachDomain\SalaryDomain\SalaryType\Model\SalaryType;
use App\Src\TimeDomain\Month\Service\Month;
use Money\Money;

class BaseSalary
{
    private Month $month;

    private Money $salary;

    private float $hours;

    private SalaryType $salaryType;

    public function __construct(Month $month, Money $salary, float $hours, SalaryType $salaryType)
    {

        $this->month = $month;
        $this->salary = $salary;
        $this->hours = $hours;
        $this->salaryType = $salaryType;
    }

    public function getMonth(): Month
    {
        return $this->month;
    }

    public function getSalary(): Money
    {
        return $this->salary;
    }

    public function getHours(): float
    {
        return $this->hours;
    }

    public function getSalaryType(): SalaryType
    {
        return $this->salaryType;
    }
}
