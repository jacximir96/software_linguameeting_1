<?php

namespace App\Src\UserDomain\User\Model\Traits;

trait Payment
{
    public function userPayment()
    {
        return $this->hasMany(\App\Src\PaymentDomain\Payment\Model\Payment::class, 'payer_id');
    }
}
