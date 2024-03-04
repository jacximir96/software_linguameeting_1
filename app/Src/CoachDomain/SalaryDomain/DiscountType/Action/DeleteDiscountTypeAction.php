<?php

namespace App\Src\CoachDomain\SalaryDomain\DiscountType\Action;

use App\Src\CoachDomain\SalaryDomain\DiscountType\Model\DiscountType;

class DeleteDiscountTypeAction
{
    public function handle(DiscountType $discountType): DiscountType
    {

        $discountType->delete();

        return $discountType;
    }
}
