<?php

namespace App\Src\InstructorDomain\InstructorCourse\Presenter\Breadcrumb\Instructor;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb implements IBreadcrumb
{
    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Active Courses');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
