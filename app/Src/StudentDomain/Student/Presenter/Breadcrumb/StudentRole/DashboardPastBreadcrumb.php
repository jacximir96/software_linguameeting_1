<?php

namespace App\Src\StudentDomain\Student\Presenter\Breadcrumb\StudentRole;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class DashboardPastBreadcrumb implements IBreadcrumb
{
    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Past Courses');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
