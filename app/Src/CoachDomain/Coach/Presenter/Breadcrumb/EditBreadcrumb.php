<?php

namespace App\Src\CoachDomain\Coach\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class EditBreadcrumb
{
    const SLUG = 'coach_edit';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create(route('get.admin.coach.index'), 'Coaches', 'List coaches');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Edit coach');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
