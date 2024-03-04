<?php

namespace App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class CoachingFormBreadcrumb
{
    const SLUG = 'coaching_form';

    use BuildLinks;

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $itemLink = $this->buildIndexCourseLink();
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Coaching form');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
