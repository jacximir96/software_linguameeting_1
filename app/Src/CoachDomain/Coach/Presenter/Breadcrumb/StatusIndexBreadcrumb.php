<?php

namespace App\Src\CoachDomain\Coach\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class StatusIndexBreadcrumb implements IBreadcrumb
{
    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Coaches Status');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
