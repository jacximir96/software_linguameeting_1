<?php

namespace App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\Student;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb implements IBreadcrumb
{
    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Experiences');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
