<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class CreateBreadcrumb
{
    const SLUG = 'bookstore_request_create';

    use BuildLinks;

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $itemLink = $this->buildIndexBookstoreLink();
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Create request');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
