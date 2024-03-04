<?php

namespace App\Src\CourseDomain\CourseCoordinator\Action;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoordinator\Model\CourseCoordinator;
use App\Src\UserDomain\User\Model\User;

class AssignCourseCoordinatorAction
{
    public function handle(Course $course, User $coordinator): CourseCoordinator
    {
        $courseCoordinator = new CourseCoordinator();
        $courseCoordinator->course_id = $course->id;
        $courseCoordinator->coordinator_id = $coordinator->id;
        $courseCoordinator->save();

        return $courseCoordinator;
    }
}
