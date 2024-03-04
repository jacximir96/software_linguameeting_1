<?php

namespace App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb\Coach;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb implements IBreadcrumb
{
    const SLUG = 'coach_experience_index';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Experiences');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
