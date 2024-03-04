<?php

namespace App\Src\Shared\Repository;

use App\Src\Shared\Service\CriteriaSearch;
use App\Src\Shared\Service\OrderListing;

interface SearchRepository
{
    public function search(CriteriaSearch $criteria, OrderListing $orderListing);
}
