<?php

namespace App\Src\CourseDomain\CourseCoordinator\Action;

use App\Src\CourseDomain\CourseCoordinator\Repository\CourseCoordinatorRepository;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class AssignMultipleCoursesAction
{
    private CourseCoordinatorRepository $courseCoordinatorRepository;

    private AssignCourseCoordinatorAction $assignCourseAction;

    public function __construct(CourseCoordinatorRepository $courseCoordinatorRepository, AssignCourseCoordinatorAction $assignCourseAction)
    {
        $this->courseCoordinatorRepository = $courseCoordinatorRepository;
        $this->assignCourseAction = $assignCourseAction;
    }

    public function handle(Collection $courses, User $instructor)
    {

        foreach ($courses as $course) {

            $courseCoordinator = $this->courseCoordinatorRepository->obtainFromCourseAndInstructor($course, $instructor);

            if ($courseCoordinator) {
                continue;
            }

            $this->assignCourseAction->handle($course, $instructor);
        }

    }
}
