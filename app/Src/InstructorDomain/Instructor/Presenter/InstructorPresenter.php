<?php

namespace App\Src\InstructorDomain\Instructor\Presenter;

use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\UserDomain\User\Model\User;


class InstructorPresenter
{
    private CourseRepository $courseRepository;

    private CommonPresenter $commonQuery;

    public function __construct(CommonPresenter $commonQuery, CourseRepository $courseRepository)
    {
        $this->commonQuery = $commonQuery;
        $this->courseRepository = $courseRepository;
    }

    public function handle(User $instructor, Int $course_id=0): InstructorResponse
    {
        $commonResponse = $this->commonQuery->handle($instructor, $course_id);

        $activeCourses = $commonResponse->activeCourses();

        $pastCourses = $commonResponse->pastCourses();

        return new InstructorResponse($commonResponse, $activeCourses, $pastCourses);
    }
}
