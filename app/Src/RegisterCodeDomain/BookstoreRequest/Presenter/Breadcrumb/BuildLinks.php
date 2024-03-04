<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;

trait BuildLinks
{
    private function buildIndexBookstoreLink(): ItemLink
    {
        $link = HtmlLink::create(route('get.admin.register_code.bookstore_request.index'), 'Bookstore Requests', 'List bookstore request');

        return new ItemLink($link);
    }
}
