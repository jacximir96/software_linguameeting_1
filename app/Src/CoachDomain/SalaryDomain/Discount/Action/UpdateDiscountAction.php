<?php

namespace App\Src\CoachDomain\SalaryDomain\Discount\Action;

use App\Src\CoachDomain\SalaryDomain\Discount\Model\Discount;
use App\Src\CoachDomain\SalaryDomain\Discount\Request\DiscountRequest;

class UpdateDiscountAction
{
    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {

        $this->processRequest = $processRequest;
    }

    public function handle(DiscountRequest $request, Discount $discount): Discount
    {

        $currency = $discount->coach->billingInfo->currency;

        return $this->processRequest->handle($request, $discount, $currency);
    }
}
