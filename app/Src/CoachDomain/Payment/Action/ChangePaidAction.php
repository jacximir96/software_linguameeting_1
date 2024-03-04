<?php

namespace App\Src\CoachDomain\Payment\Action;

use App\Src\CoachDomain\Payment\Model\Payment;

class ChangePaidAction
{
    public function handle(Payment $payment): Payment
    {

        $payment->is_paid = ! $payment->is_paid;
        $payment->save();

        return $payment;
    }
}
