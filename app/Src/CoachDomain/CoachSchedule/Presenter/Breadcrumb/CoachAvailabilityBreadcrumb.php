<?php

namespace App\Src\CoachDomain\CoachSchedule\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\IBreadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class CoachAvailabilityBreadcrumb implements IBreadcrumb
{
    const SLUG = 'coach_role_availability';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Availability');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
