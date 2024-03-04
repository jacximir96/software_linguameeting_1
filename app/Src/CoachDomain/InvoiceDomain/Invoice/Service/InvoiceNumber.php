<?php

namespace App\Src\CoachDomain\InvoiceDomain\Invoice\Service;

class InvoiceNumber
{
    private string $number;

    public function __construct(string $number)
    {

        $this->number = $number;
    }

    public function get(): string
    {
        return $this->number;
    }
}
