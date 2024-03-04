<?php

namespace App\Src\CourseDomain\AssignmentChapter\Repository;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\AssignmentChapter\Model\AssignmentChapter;

class AssignmentChapterRepository
{
    public function findBySectionAssignment(Assignment $courseAssignment)
    {
        return AssignmentChapter::query()
            ->where('assignment_id', $courseAssignment->id)
            ->get();
    }
}
