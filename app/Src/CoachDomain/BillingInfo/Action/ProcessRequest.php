<?php

namespace App\Src\CoachDomain\BillingInfo\Action;

use App\Src\CoachDomain\BillingInfo\Model\BillingInfo;
use App\Src\CoachDomain\BillingInfo\Request\BillingProfileInfoRequest;

class ProcessRequest
{
    public function handle(BillingProfileInfoRequest $request, BillingInfo $billingInfo): BillingInfo
    {

        $billingInfo->full_name = $request->full_name;
        $billingInfo->ind = $request->ind;
        $billingInfo->address = $request->address;
        $billingInfo->postal_code = $request->postal_code;
        $billingInfo->city = $request->city;
        $billingInfo->country_id = $request->country_id;

        $billingInfo->bank_name = $request->bank_name;
        $billingInfo->bank_account = $request->bank_account;
        $billingInfo->bank_observations = $request->bank_observations ?? '';
        $billingInfo->swift = $request->swift;
        $billingInfo->route_number = $request->route_number;
        $billingInfo->account_type_id = $request->account_type_id;

        $billingInfo->method_payment_id = $request->method_payment_id;
        $billingInfo->currency_id = $request->currency_id;
        $billingInfo->paypal_email = $request->paypal_email ?? '';
        $billingInfo->paid_info = $request->paid_info ?? '';

        $billingInfo->save();

        return $billingInfo;
    }
}
