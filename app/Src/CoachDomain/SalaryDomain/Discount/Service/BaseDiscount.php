<?php

namespace App\Src\CoachDomain\SalaryDomain\Discount\Service;

use App\Src\TimeDomain\Month\Service\Month;
use Money\Money;

class BaseDiscount
{
    private Month $mont;

    private Money $discount;

    public function __construct(Month $mont, Money $discount)
    {
        $this->mont = $mont;
        $this->discount = $discount;
    }

    public function getMont(): Month
    {
        return $this->mont;
    }

    public function getDiscount(): Money
    {
        return $this->discount;
    }

    public function hasDiscount(): bool
    {
        return $this->discount->getAmount() > 0;
    }
}
