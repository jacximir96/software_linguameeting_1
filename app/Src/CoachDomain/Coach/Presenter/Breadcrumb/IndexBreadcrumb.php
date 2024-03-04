<?php

namespace App\Src\CoachDomain\Coach\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb
{
    const SLUG = 'coach_index';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Coaches');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
