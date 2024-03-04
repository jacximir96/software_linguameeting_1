<?php

namespace App\Src\UniversityDomain\Instructor\Action;

use App\Src\UniversityDomain\Instructor\Model\UniversityInstructor;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;

class UnassignUniversityAction
{
    public function handle(User $instructor, University $university)
    {
        $item = UniversityInstructor::query()
            ->where('instructor_id', $instructor->id)
            ->where('university_id', $university->id)
            ->firstOrFail();

        $item->delete();
    }
}
