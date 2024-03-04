<?php

namespace App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class EditBreadcrumb
{
    const SLUG = 'instructor_edit';

    use BuildLinks;

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $itemLink = $this->buildIndexInstructorLink();
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Edit instructor');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
