<?php

namespace App\Src\StudentRole\Course\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class ShowBreadcrumb implements IBreadcrumb
{
    const SLUG = 'coach_show';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Course');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
