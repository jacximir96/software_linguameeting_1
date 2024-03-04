<?php

namespace App\Http\Controllers\Admin;

use App\Src\Shared\Service\OrderListing;

trait Orderable
{
    public function obtainOrderListing(string $defaultField, string $defaultDirection = 'asc'): OrderListing
    {
        $orderListing = new OrderListing($defaultField, $defaultDirection);
        $orderListing->configFromRequest();

        return $orderListing;
    }
}
