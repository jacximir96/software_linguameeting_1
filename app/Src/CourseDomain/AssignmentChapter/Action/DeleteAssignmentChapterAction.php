<?php

namespace App\Src\CourseDomain\AssignmentChapter\Action;

use App\Src\CourseDomain\AssignmentChapter\Model\AssignmentChapter;

class DeleteAssignmentChapterAction
{
    public function handle(AssignmentChapter $assignmentChapter)
    {
        $assignmentChapter->delete();
    }
}
