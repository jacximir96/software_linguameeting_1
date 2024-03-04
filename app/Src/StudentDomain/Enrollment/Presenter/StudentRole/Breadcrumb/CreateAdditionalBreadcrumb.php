<?php

namespace App\Src\StudentDomain\Enrollment\Presenter\StudentRole\Breadcrumb;


use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class CreateAdditionalBreadcrumb implements IBreadcrumb
{

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('New Course ');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
