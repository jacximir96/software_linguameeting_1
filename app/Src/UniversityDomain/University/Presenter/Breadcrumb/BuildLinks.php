<?php

namespace App\Src\UniversityDomain\University\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;

trait BuildLinks
{
    private function buildIndexUniversityLink(): ItemLink
    {
        $link = HtmlLink::create(route('get.admin.university.index'), 'Universities', 'List universities');

        return new ItemLink($link);
    }
}
