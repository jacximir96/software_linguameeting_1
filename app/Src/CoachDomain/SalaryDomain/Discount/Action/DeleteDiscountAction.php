<?php

namespace App\Src\CoachDomain\SalaryDomain\Discount\Action;

use App\Src\CoachDomain\SalaryDomain\Discount\Model\Discount;

class DeleteDiscountAction
{
    public function handle(Discount $discount): Discount
    {

        $discount->delete();

        return $discount;
    }
}
