<?php

namespace App\Src\CourseDomain\AssignmentChapter\Action;

use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\AssignmentChapter\Model\AssignmentChapter;

class CreateAssignmentChapterAction
{
    public function handle(Assignment $assignment, Chapter $chapter): AssignmentChapter
    {

        $assignmentChapter = new AssignmentChapter();
        $assignmentChapter->assignment_id = $assignment->id;
        $assignmentChapter->chapter_id = $chapter->id;
        $assignmentChapter->save();

        return $assignmentChapter;
    }
}
