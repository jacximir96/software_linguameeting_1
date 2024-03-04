<?php

namespace App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class ShowBreadcrumb
{
    const SLUG = 'instructor_show';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $link = HtmlLink::create(route('get.admin.instructor.index'), 'Instructors', 'List instructors');
        $itemLink = new ItemLink($link);
        $breadcrumb->push($itemLink);

        $tag = new ItemTag('Instructor card');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
