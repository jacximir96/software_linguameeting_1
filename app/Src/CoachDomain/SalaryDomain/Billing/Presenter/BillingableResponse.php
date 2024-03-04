<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Presenter;

trait BillingableResponse
{
    public function isTransferPaid(): bool
    {

        $methodPayment = $this->getMonthBilling()->coach()->billingInfo->methodPayment;

        return $methodPayment->isTransfer();
    }

    public function isPaypalPaid(): bool
    {

        $methodPayment = $this->getMonthBilling()->coach()->billingInfo->methodPayment;

        return $methodPayment->isPaypal();
    }
}
