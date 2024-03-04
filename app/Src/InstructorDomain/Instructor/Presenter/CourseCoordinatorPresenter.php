<?php

namespace App\Src\InstructorDomain\Instructor\Presenter;

use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class CourseCoordinatorPresenter
{
    private CourseRepository $courseRepository;

    private CommonPresenter $commonQuery;

    public function __construct(CommonPresenter $commonQuery, CourseRepository $courseRepository)
    {
        $this->commonQuery = $commonQuery;
        $this->courseRepository = $courseRepository;
    }

    public function handle(User $instructor): CourseCoordinatorResponse
    {
        $commonResponse = $this->commonQuery->handle($instructor);

        $courses = $this->obtainCoursesThanInstructorIsAssigned($instructor);

        return new CourseCoordinatorResponse($commonResponse, $courses);
    }

    private function obtainCoursesThanInstructorIsAssigned(User $instructor): Collection
    {

        $activeCourses = collect();

        $coursesAsCoordinator = $this->courseRepository->obtainCourseFromCourseCoordinator($instructor);

        foreach ($coursesAsCoordinator as $course) {

            if ($course->isActive()) {
                $activeCourses->put($course->id, $course);
            }
        }

        $activeCourses = $activeCourses->sortBy(function ($course) {
            return $course->university->name.'-'.$course->name;
        });

        return $activeCourses;
    }
}
