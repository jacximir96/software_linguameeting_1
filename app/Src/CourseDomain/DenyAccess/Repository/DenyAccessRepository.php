<?php

namespace App\Src\CourseDomain\DenyAccess\Repository;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\DenyAccess\Model\DenyAccess;
use App\Src\UserDomain\User\Model\User;

class DenyAccessRepository
{
    public function obtainByCourseAndUser(Course $course, User $user)
    {

        return DenyAccess::query()
            ->where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->first();

    }
}
