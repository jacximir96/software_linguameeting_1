<?php

namespace App\Src\CourseDomain\Assignment\Action;

use App\Src\CourseDomain\Assignment\Model\Assignment;

class DeleteAssignmentAction
{
    public function handle(Assignment $assignment)
    {
        $assignment->chapter()->delete();

        $assignment->file()->delete();

        $assignment->delete();
    }
}
