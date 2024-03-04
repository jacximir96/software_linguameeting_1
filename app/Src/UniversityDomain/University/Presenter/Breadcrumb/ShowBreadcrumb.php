<?php

namespace App\Src\UniversityDomain\University\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class ShowBreadcrumb
{
    const SLUG = 'university_show';

    use BuildLinks;

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $itemLink = $this->buildIndexUniversityLink();
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('University details');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
