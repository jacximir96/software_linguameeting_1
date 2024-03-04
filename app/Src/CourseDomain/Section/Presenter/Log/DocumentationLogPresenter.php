<?php

namespace App\Src\CourseDomain\Section\Presenter\Log;

use App\Src\ActivityLog\Model\Activity;
use App\Src\CourseDomain\Section\Model\Section;


class DocumentationLogPresenter
{
    public function handle(Section $section): DocumentationLogResponse
    {
        $activity = Activity::forSubject($section)->orderByDesc('id')->get();

        return new DocumentationLogResponse($activity);
    }
}
