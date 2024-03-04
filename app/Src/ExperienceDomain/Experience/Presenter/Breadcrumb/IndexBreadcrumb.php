<?php

namespace App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb
{
    const SLUG = 'experience_index';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Experiences');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
