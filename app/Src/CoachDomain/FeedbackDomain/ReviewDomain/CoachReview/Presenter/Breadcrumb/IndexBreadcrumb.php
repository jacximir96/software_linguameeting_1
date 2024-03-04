<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb implements IBreadcrumb
{
    const SLUG = 'review_index';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Coaches Reviews');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
