<?php

namespace App\Src\PaymentDomain\Payment\Service;

use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\RegisterCodeDomain\RegisterCode\Model\RegisterCode;
use App\Src\UserDomain\User\Model\UserPayable;
use Money\Money;

class CodePaymentDto
{
    private DetailCollection $detailCollection;
    private UserPayable $user;
    private RegisterCode $registerCode;
    private Money $amount;

    public function __construct(DetailCollection $detailCollection, UserPayable $user, RegisterCode $registerCode, Money $amount)
    {

        $this->detailCollection = $detailCollection;
        $this->user = $user;
        $this->registerCode = $registerCode;
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

    public function getRegisterCode(): RegisterCode
    {
        return $this->registerCode;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }
}
