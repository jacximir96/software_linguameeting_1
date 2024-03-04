<?php

namespace App\Src\PaymentDomain\Payment\Action\Command;

use App\Src\PaymentDomain\Payment\Model\Payment;
use App\Src\PaymentDomain\PaymentDetail\Model\PaymentDetail;
use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\UserDomain\User\Model\User;
use App\Src\UserDomain\User\Model\UserPayable;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Money\Money;

class PaymentBuilder
{
    public function buildPayment(UserPayable $user, Money $amount): Payment
    {

        $payment = new Payment();

        if ($user instanceof User) {
            $payment->payer_id = $user->id;
        } else {
            $payment->payer_public_id = $user->id;
        }

        $payment->value = $amount;
        $payment->paid_at = Carbon::now();
        $payment->email = $user->email;

        return $payment;

    }

    public function createDetail (DetailCollection $detailCollection, Payment $payment):Collection{

        $details = collect();

        foreach ($detailCollection->get() as $item){

            $detail = new PaymentDetail();
            $detail->payable_type = $item->morphType();
            $detail->payable_id = $item->id;
            $detail->payment_id = $payment->id;

            $detail->save();

            $details->push($detail);
        }

        return $details;
    }
}
