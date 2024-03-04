<?php

namespace App\Src\CourseDomain\AssignmentFile\Action;

use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;

class DeleteAssignmentFileAction
{
    public function handle(AssignmentFile $assignmentFile)
    {
        $assignmentFile->delete();
    }
}
