<?php

namespace App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class CreateBreadcrumb
{
    const SLUG = 'instructor_create';

    use BuildLinks;

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $itemLink = $this->buildIndexInstructorLink();
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Create instructor');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
