<?php

namespace App\Src\CoachDomain\SalaryDomain\Discount\Service;

use App\Src\CoachDomain\SalaryDomain\Discount\Repository\DiscountRepository;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;
use Money\Money;

class DiscountCalculator
{
    private DiscountRepository $discountRepository;

    private LinguaMoney $linguaMoney;

    public function __construct(DiscountRepository $discountRepository, LinguaMoney $linguaMoney)
    {
        $this->discountRepository = $discountRepository;
        $this->linguaMoney = $linguaMoney;
    }

    public function calculateForMonthAndCoach(Month $month, User $coach)
    {

        $discounts = $this->obtainPuntualDiscounts($month, $coach);

        return new BaseDiscount($month, $discounts);
    }

    private function obtainPuntualDiscounts(Month $month, User $coach): Money
    {

        $total = $this->linguaMoney->buildZero($coach->currency()->code);

        $discounts = $this->discountRepository->obtainPuntualDiscounts($month, $coach);

        foreach ($discounts as $discount) {
            $total = $total->add($discount->value);
        }

        return $total;
    }
}
