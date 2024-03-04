<?php

namespace App\Src\CoachDomain\BillingInfo\Action\Command;

use App\Src\CoachDomain\BillingInfo\Model\BillingInfo;
use App\Src\PaymentDomain\AccountType\Model\AccountType;
use App\Src\PaymentDomain\Currency\Model\Currency;
use App\Src\PaymentDomain\MethodPayment\Model\MethodPayment;
use App\Src\UserDomain\User\Model\User;

class CreateBillingInfoDefaultCommand
{
    public function handle(User $coach): BillingInfo
    {

        $billingInfo = new BillingInfo();
        $billingInfo->user_id = $coach->id;
        $billingInfo->method_payment_id = MethodPayment::ID_PAYPAL;
        $billingInfo->currency_id = Currency::DOLLAR_ID;
        $billingInfo->country_id = $coach->country->id;
        $billingInfo->account_type_id = AccountType::CHECKING_ACCOUNT_ID;

        $billingInfo->full_name = $coach->name.' '.$coach->lastname;

        $billingInfo->save();

        return $billingInfo;
    }
}
