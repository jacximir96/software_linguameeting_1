<?php

namespace App\Src\CoachDomain\Calendar\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class CoachCalendarBreadcrumb implements IBreadcrumb
{
    const SLUG = 'coach_role_calendar';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Calendar');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
