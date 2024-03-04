<?php

namespace App\Src\InstructorDomain\InstructorHelp\Presenter\Breadcrumb\Instructor;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb implements IBreadcrumb
{
    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Help');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
