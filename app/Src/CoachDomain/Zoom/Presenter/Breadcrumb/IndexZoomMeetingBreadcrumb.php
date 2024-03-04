<?php

namespace App\Src\CoachDomain\Zoom\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexZoomMeetingBreadcrumb
{
    const SLUG = 'coach_zoom_index';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Zoom Meetings');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
