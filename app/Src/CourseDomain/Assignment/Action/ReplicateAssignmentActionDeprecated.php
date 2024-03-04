<?php

namespace App\Src\CourseDomain\Assignment\Action;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\Section\Model\Section;

class ReplicateAssignmentActionDeprecated
{
    public function handle(Section $mainSection, Section $secondarySection)
    {
        foreach ($mainSection->assignment as $mainAssignment) {
            $newAssignment = $this->replicateAssignment($mainAssignment, $secondarySection);

            $this->replicateChapter($mainAssignment, $newAssignment);

            $this->replicateFile($mainAssignment, $newAssignment);
        }
    }

    private function replicateAssignment(Assignment $mainAssignment, Section $secondarySection): Assignment
    {
        $newAssignment = $mainAssignment->replicate();
        $newAssignment->section_id = $secondarySection->id;
        $newAssignment->save();

        return $newAssignment;
    }

    private function replicateChapter(Assignment $mainAssignment, Assignment $newAssignment)
    {
        $chapter = $mainAssignment->chapter;

        if (is_null($chapter)) {
            return;
        }

        $newChapter = $mainAssignment->chapter->replicate();
        $newChapter->assignment_id = $newAssignment->id;
        $newChapter->save();
    }

    private function replicateFile(Assignment $mainAssignment, Assignment $newAssignment)
    {
        $file = $mainAssignment->file;

        if (is_null($file)) {
            return;
        }

        $newFile = $mainAssignment->file->replicate();
        $newFile->assignment_id = $newAssignment->id;
        $newFile->save();
    }
}
