<?php

namespace App\Src\CoachDomain\SalaryDomain\DiscountType\Action;

use App\Src\CoachDomain\SalaryDomain\DiscountType\Model\DiscountType;
use App\Src\CoachDomain\SalaryDomain\DiscountType\Request\DiscountTypeRequest;

class UpdateDiscountTypeAction
{
    public function handle(DiscountTypeRequest $request, DiscountType $discountType): DiscountType
    {

        $discountType->name = $request->name;
        $discountType->description = $request->description;

        $discountType->save();

        return $discountType;
    }
}
