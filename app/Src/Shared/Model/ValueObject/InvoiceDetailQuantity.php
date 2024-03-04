<?php

namespace App\Src\Shared\Model\ValueObject;

class InvoiceDetailQuantity
{
    private int $value;

    public function __construct(int $value)
    {

        if ($value < 0) {
            throw new \InvalidArgumentException(sprintf('Invoice detail quantity not valid : %s', $value));
        }

        $this->value = $value;
    }

    public function get(): int
    {
        return $this->value;
    }
}
