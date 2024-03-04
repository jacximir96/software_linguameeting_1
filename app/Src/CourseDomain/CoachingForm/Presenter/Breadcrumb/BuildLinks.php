<?php

namespace App\Src\CourseDomain\CoachingForm\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;

trait BuildLinks
{
    private function buildIndexCourseLink(): ItemLink
    {
        $link = HtmlLink::create(route('get.admin.course.index'), 'Courses', 'Courses list');

        return new ItemLink($link);
    }
}
