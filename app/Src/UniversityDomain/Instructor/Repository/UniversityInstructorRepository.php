<?php

namespace App\Src\UniversityDomain\Instructor\Repository;

use App\Src\UniversityDomain\Instructor\Model\UniversityInstructor;

class UniversityInstructorRepository
{
    public function obtainUniversityAndInstructorOrNull(int $universityId, int $userId)
    {
        return UniversityInstructor::query()
            ->where('university_id', $universityId)
            ->where('instructor_id', $userId)
            ->first();
    }
}
