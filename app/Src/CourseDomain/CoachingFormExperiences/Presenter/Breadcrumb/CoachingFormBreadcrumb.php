<?php

namespace App\Src\CourseDomain\CoachingFormExperiences\Presenter\Breadcrumb;

use App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb\BuildLinks;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class CoachingFormBreadcrumb
{
    const SLUG = 'coaching_form_experiences';

    use BuildLinks;

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $itemLink = $this->buildIndexCourseLink();
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Live Experiences');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
