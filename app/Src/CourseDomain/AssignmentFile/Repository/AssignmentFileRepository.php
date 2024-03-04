<?php

namespace App\Src\CourseDomain\AssignmentFile\Repository;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;

class AssignmentFileRepository
{
    public function findByAssignment(Assignment $assignment)
    {

        return AssignmentFile::query()
            ->where('assignment_id', $assignment->id)
            ->first();
    }
}
