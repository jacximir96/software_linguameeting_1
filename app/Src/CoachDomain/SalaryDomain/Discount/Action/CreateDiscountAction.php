<?php

namespace App\Src\CoachDomain\SalaryDomain\Discount\Action;

use App\Src\CoachDomain\SalaryDomain\Discount\Model\Discount;
use App\Src\CoachDomain\SalaryDomain\Discount\Request\DiscountRequest;
use App\Src\UserDomain\User\Model\User;

class CreateDiscountAction
{
    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {

        $this->processRequest = $processRequest;
    }

    public function handle(DiscountRequest $request, User $coach): Discount
    {

        $discount = new Discount();
        $discount->coach_id = $coach->id;

        $currency = $coach->billingInfo->currency;

        return $this->processRequest->handle($request, $discount, $currency);
    }
}
