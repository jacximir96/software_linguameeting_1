<?php

namespace App\Src\CourseDomain\CourseCoordinator\Action;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\CourseCoordinator\Repository\CourseCoordinatorRepository;
use App\Src\CourseDomain\CourseCoordinator\Request\ChangeCourseCoordinatorRequest;
use App\Src\UserDomain\User\Model\User;

class ChangeCourseCoordinatorAction
{
    private CourseCoordinatorRepository $courseCoordinatorRepository;

    private AssignCourseCoordinatorAction $assignCourseAction;

    private DeleteCourseCoordinatorAction $deleteCourseCoordinatorAction;

    public function __construct(CourseCoordinatorRepository $courseCoordinatorRepository,
        AssignCourseCoordinatorAction $assignCourseAction,
        DeleteCourseCoordinatorAction $deleteCourseCoordinatorAction)
    {

        $this->courseCoordinatorRepository = $courseCoordinatorRepository;
        $this->assignCourseAction = $assignCourseAction;
        $this->deleteCourseCoordinatorAction = $deleteCourseCoordinatorAction;
    }

    public function handle(ChangeCourseCoordinatorRequest $request, Course $course)
    {

        $courseCoordinator = $this->courseCoordinatorRepository->obtainFromCourse($course);

        if ($courseCoordinator) {

            if ($request->hasCourseCoordinatorSelect()) {

                $instructorSelected = $this->obtainIntructorSelected($request);

                if ($courseCoordinator->isOtherCoordinator($instructorSelected)) {

                    $this->deleteCurrentCoordinator($course);

                    $this->assignNewCoordinator($request, $course);
                }
            } else {
                $this->deleteCurrentCoordinator($course);
            }
        } else {

            if ($request->hasCourseCoordinatorSelect()) {
                $this->assignNewCoordinator($request, $course);
            }
        }
    }

    private function deleteCurrentCoordinator(Course $course)
    {
        $this->deleteCourseCoordinatorAction->handle($course);
    }

    private function assignNewCoordinator(ChangeCourseCoordinatorRequest $request, Course $course)
    {
        $instructor = $this->obtainIntructorSelected($request);
        $this->assignCourseAction->handle($course, $instructor);
    }

    private function obtainIntructorSelected(ChangeCourseCoordinatorRequest $request): User
    {
        return User::find($request->instructor_id);
    }
}
