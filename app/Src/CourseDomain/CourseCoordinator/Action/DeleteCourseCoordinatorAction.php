<?php

namespace App\Src\CourseDomain\CourseCoordinator\Action;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoordinator\Repository\CourseCoordinatorRepository;

class DeleteCourseCoordinatorAction
{
    private CourseCoordinatorRepository $courseCoordinatorRepository;

    public function __construct(CourseCoordinatorRepository $courseCoordinatorRepository)
    {

        $this->courseCoordinatorRepository = $courseCoordinatorRepository;
    }

    public function handle(Course $course)
    {

        $courseCoordinator = $this->courseCoordinatorRepository->obtainFromCourse($course);

        if ($courseCoordinator) {
            $courseCoordinator->delete();
        }
    }
}
