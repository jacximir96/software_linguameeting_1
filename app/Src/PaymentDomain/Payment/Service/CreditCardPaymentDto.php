<?php

namespace App\Src\PaymentDomain\Payment\Service;

use App\Src\PaymentDomain\PaymentDetail\Service\DetailCollection;
use App\Src\Shared\Model\Morpheable;
use App\Src\ThirdPartiesDomain\Braintree\Service\TransactionResponse;
use App\Src\UserDomain\User\Model\UserPayable;
use Money\Money;

class CreditCardPaymentDto
{

    private DetailCollection $detailCollection;

    private Morpheable $payable;

    private UserPayable $user;

    private TransactionResponse $transactionResponse;

    private Money $amount;

    public function __construct(DetailCollection $detailCollection, UserPayable $user, TransactionResponse $transactionResponse, Money $amount)
    {
        $this->detailCollection = $detailCollection;
        $this->user = $user;
        $this->transactionResponse = $transactionResponse;
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

    public function getTransactionResponse(): TransactionResponse
    {
        return $this->transactionResponse;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }
}
