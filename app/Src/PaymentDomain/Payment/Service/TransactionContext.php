<?php

namespace App\Src\PaymentDomain\Payment\Service;

class TransactionContext
{
    private string $context;

    private array $data;

    public function __construct(string $context, array $data = [])
    {
        $this->context = $context;
        $this->data = $data;
    }

    public function getContext(): string
    {
        return $this->context;
    }

    public function getData(): array
    {
        return $this->data;
    }
}
