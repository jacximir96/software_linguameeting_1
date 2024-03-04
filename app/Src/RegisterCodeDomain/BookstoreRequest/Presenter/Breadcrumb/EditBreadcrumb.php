<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;
use App\Src\UniversityDomain\University\Model\University;

class EditBreadcrumb
{
    const SLUG = 'bookstore_request_edit';

    use BuildLinks;

    public function handle(University $university): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $itemLink = $this->buildIndexUniversityLink();
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Edit '.$university->name);
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
