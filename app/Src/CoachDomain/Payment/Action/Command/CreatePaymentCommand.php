<?php

namespace App\Src\CoachDomain\Payment\Action\Command;

use App\Src\CoachDomain\Payment\Model\Payment;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;
use Money\Money;

class CreatePaymentCommand
{
    public function handle(Month $month, User $coach, Money $value): Payment
    {
        $payment = new Payment();
        $payment->coach_id = $coach->id;
        $payment->month = $month->month();
        $payment->year = $month->year();
        $payment->is_paid = true;

        $payment->value = $value;
        $payment->save();

        return $payment;
    }
}
