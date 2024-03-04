<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Presenter\Breadcrumb\Coach;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb implements IBreadcrumb
{
    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Students Feedbacks');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
