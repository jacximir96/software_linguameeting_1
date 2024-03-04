<?php

namespace App\Src\ThirdPartiesDomain\Braintree\Service;

class TransactionRefundDto
{
    private TransactionId $transactionId;

    public function __construct(TransactionId $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    public function transactionId(): TransactionId
    {
        return $this->transactionId;
    }
}
