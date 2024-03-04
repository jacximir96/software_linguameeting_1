<?php

namespace App\Src\UniversityDomain\University\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class CreateBreadcrumb
{
    const SLUG = 'university_create';

    use BuildLinks;

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $itemLink = $this->buildIndexUniversityLink();
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Create university');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
