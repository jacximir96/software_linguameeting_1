<?php

namespace App\Src\CourseDomain\Course\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb
{
    const SLUG = 'course_index';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Courses');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
