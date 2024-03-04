<?php

namespace App\Src\CourseDomain\Assignment\Action\Command;

use App\Src\ConversationGuideDomain\Chapter\Model\Chapter;
use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\AssignmentChapter\Action\CreateAssignmentChapterAction;
use App\Src\CourseDomain\AssignmentChapter\Action\DeleteAssignmentChapterAction;
use App\Src\CourseDomain\AssignmentChapter\Action\UpdateAssignmentChapterAction;
use App\Src\CourseDomain\AssignmentChapter\Model\AssignmentChapter;

class ChapterCommand
{
    private CreateAssignmentChapterAction $createAssignmentChapterAction;

    private UpdateAssignmentChapterAction $updateAssignmentChapterAction;

    private DeleteAssignmentChapterAction $deleteAssignmentChapterAction;

    public function __construct(CreateAssignmentChapterAction $createAssignmentChapterAction,
        UpdateAssignmentChapterAction $updateAssignmentChapterAction,
        DeleteAssignmentChapterAction $deleteAssignmentChapterAction)
    {

        $this->createAssignmentChapterAction = $createAssignmentChapterAction;
        $this->updateAssignmentChapterAction = $updateAssignmentChapterAction;
        $this->deleteAssignmentChapterAction = $deleteAssignmentChapterAction;
    }

    public function assignChapterToAssignment(Assignment $assignment, int $chapterId): AssignmentChapter
    {

        $chapter = Chapter::find($chapterId);

        if ($assignment->chapter) {
            return $this->updateAssignmentChapterAction->handle($assignment->chapter, $chapter);
        } else {
            return $this->createAssignmentChapterAction->handle($assignment, $chapter);
        }
    }

    public function removeChapterFromAssignment(Assignment $assignment)
    {

        if ($assignment->chapter) {
            $this->deleteAssignmentChapterAction->handle($assignment->chapter);
        }
    }
}
