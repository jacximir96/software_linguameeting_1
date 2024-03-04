<?php

namespace App\Src\CourseDomain\Assignment\Action\Command;

use App\Src\CourseDomain\Assignment\Action\DeleteAssignmentAction;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;

class DeleteAssignmentCommand
{
    private DeleteAssignmentAction $deleteAssignmentAction;

    public function __construct(DeleteAssignmentAction $deleteAssignmentAction)
    {

        $this->deleteAssignmentAction = $deleteAssignmentAction;
    }

    public function deleteFromCourse(Course $course)
    {
        foreach ($course->section as $section) {
            foreach ($section->assignment as $assignment) {
                $this->deleteAssignmentAction->handle($assignment);
            }
        }
    }

    public function deleteFromSection(Section $section)
    {
        foreach ($section->assignment as $assignment) {
            $this->deleteAssignmentAction->handle($assignment);
        }
    }
}
