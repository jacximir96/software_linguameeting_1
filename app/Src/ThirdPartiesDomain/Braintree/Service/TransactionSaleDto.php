<?php

namespace App\Src\ThirdPartiesDomain\Braintree\Service;

class TransactionSaleDto
{
    private string $firstName;

    private string $lastName;

    private float $amount;

    private string $nonce;

    public function __construct(string $firstName, string $lastName, float $amount, string $nonce)
    {

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->amount = $amount;
        $this->nonce = $nonce;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getNonce(): string
    {
        return $this->nonce;
    }
}
