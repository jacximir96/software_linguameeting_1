<?php

namespace App\Src\RegisterCodeDomain\RegisterCode\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class SearchBreadcrumb implements IBreadcrumb
{
    const SLUG = 'bookstore_code_search';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create(route('get.admin.register_code.bookstore_request.index'), 'Bookstore Requests', 'List bookstore request');
        $item = new ItemLink($link);
        $breadcrumb->push($item);

        $tag = new ItemTag('Search codes');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
