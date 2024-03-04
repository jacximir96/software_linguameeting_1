<?php

namespace App\Src\StudentDomain\Student\Presenter\Breadcrumb;

use App\Src\Shared\Presenter\Breadcrumb\Breadcrumb;
use App\Src\Shared\Presenter\Breadcrumb\ItemTag;

class IndexBreadcrumb
{
    const SLUG = 'student_index';

    public function handle(): Breadcrumb
    {
        $breadcrumb = Breadcrumb::buildWithDashboard();

        $tag = new ItemTag('Students');
        $breadcrumb->push($tag);

        return $breadcrumb;
    }
}
