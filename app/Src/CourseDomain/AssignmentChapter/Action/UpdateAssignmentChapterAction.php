<?php

namespace App\Src\CourseDomain\AssignmentChapter\Action;

use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\CourseDomain\AssignmentChapter\Model\AssignmentChapter;

class UpdateAssignmentChapterAction
{
    public function handle(AssignmentChapter $assignmentChapter, Chapter $chapter): AssignmentChapter
    {

        $assignmentChapter->chapter_id = $chapter->id;
        $assignmentChapter->save();

        return $assignmentChapter;

    }
}
