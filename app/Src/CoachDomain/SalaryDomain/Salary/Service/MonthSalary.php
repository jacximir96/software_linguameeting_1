<?php

namespace App\Src\CoachDomain\SalaryDomain\Salary\Service;

use App\Src\CoachDomain\SalaryDomain\Discount\Service\BaseDiscount;
use App\Src\CoachDomain\SalaryDomain\Incentive\Service\BaseIncentive;
use Money\Money;

class MonthSalary
{
    private BaseSalary $baseSalary;

    private BaseIncentive $baseIncentive;

    private BaseDiscount $baseDiscount;

    private ExtraSalary $extraSalary;

    public function __construct(BaseSalary $baseSalary, BaseIncentive $baseIncentive, BaseDiscount $baseDiscount, ExtraSalary $extraSalary)
    {

        $this->baseSalary = $baseSalary;
        $this->baseIncentive = $baseIncentive;
        $this->baseDiscount = $baseDiscount;
        $this->extraSalary = $extraSalary;
    }

    public function baseSalary(): BaseSalary
    {
        return $this->baseSalary;
    }

    public function baseIncentive(): BaseIncentive
    {
        return $this->baseIncentive;
    }

    public function baseDiscount(): BaseDiscount
    {
        return $this->baseDiscount;
    }

    public function extraSalary(): ExtraSalary
    {
        return $this->extraSalary;
    }

    public function total(): Money
    {

        $total = $this->baseSalary->getSalary();

        $total = $total->add($this->baseIncentive->total());

        $total = $total->subtract($this->baseDiscount->getDiscount());

        $total = $total->add($this->extraSalary->getExtraSalary());

        return $total;
    }

    public function hours(): float
    {
        return $this->baseSalary->getHours();
    }
}
