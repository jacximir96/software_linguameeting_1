<?php

namespace App\Src\InstructorDomain\Instructor\Presenter\Breadcrumb;

use App\Src\Shared\Model\ValueObject\HtmlLink;
use App\Src\Shared\Presenter\Breadcrumb\ItemLink;

trait BuildLinks
{
    private function buildIndexInstructorLink(): ItemLink
    {
        $link = HtmlLink::create(route('get.admin.instructor.index'), 'Instructors', 'List instructors');

        return new ItemLink($link);
    }
}
