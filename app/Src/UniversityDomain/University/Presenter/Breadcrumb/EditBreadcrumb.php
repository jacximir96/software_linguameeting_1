<?php

namespace App\Src\UniversityDomain\University\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class EditBreadcrumb
{
    const SLUG = 'university_edit';

    use BuildLinks;

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $itemLink = $this->buildIndexUniversityLink();
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Edit university');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
