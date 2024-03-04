<?php

namespace App\Src\CoachDomain\Coach\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;

trait BuildLinks
{
    private function buildIndexCoachLink(): ItemLink
    {
        $link = HtmlLink::create(route('get.admin.coach.index'), 'Coaches', 'List coaches');

        return new ItemLink($link);
    }
}
