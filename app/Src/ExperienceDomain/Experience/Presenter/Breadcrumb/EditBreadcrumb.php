<?php

namespace App\Src\ExperienceDomain\Experience\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class EditBreadcrumb
{
    const SLUG = 'experience_edit';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create(route('get.admin.experience.index'), 'Experiences', 'List Experiences');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Edit Experience');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
