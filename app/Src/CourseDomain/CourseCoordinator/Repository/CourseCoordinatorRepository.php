<?php

namespace App\Src\CourseDomain\CourseCoordinator\Repository;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoordinator\Model\CourseCoordinator;
use App\Src\UserDomain\User\Model\User;

class CourseCoordinatorRepository
{
    public function obtainFromCourse(Course $course)
    {

        return CourseCoordinator::query()
            ->where('course_id', $course->id)
            ->first();

    }

    public function obtainFromCourseAndInstructor(Course $course, User $instructor)
    {

        return CourseCoordinator::query()
            ->where('course_id', $course->id)
            ->where('coordinator_id', $instructor->id)
            ->first();

    }
}
