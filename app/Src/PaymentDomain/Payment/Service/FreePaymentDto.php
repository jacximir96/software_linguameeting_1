<?php

namespace App\Src\PaymentDomain\Payment\Service;

use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\UserDomain\User\Model\UserPayable;
use Money\Money;

class FreePaymentDto
{
    private DetailCollection $detailCollection;
    private UserPayable $user;
    private Money $amount;

    public function __construct(DetailCollection $detailCollection, UserPayable $user, Money $amount)
    {
        $this->detailCollection = $detailCollection;
        $this->user = $user;
        $this->amount = $amount;
    }

    public function getDetailCollection(): DetailCollection
    {
        return $this->detailCollection;
    }

    public function getUser(): UserPayable
    {
        return $this->user;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }
}
