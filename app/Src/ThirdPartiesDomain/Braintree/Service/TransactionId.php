<?php

namespace App\Src\ThirdPartiesDomain\Braintree\Service;

class TransactionId
{
    private string $id;

    public function __construct(string $id)
    {

        $this->id = $id;
    }

    public function get(): string
    {
        return $this->id;
    }
}
