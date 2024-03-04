<?php

namespace App\Src\InstructorDomain\Instructor\Presenter;

use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class CoordinatorPresenter
{
    private CourseRepository $courseRepository;

    private CommonPresenter $commonQuery;

    public function __construct(CommonPresenter $commonQuery, CourseRepository $courseRepository)
    {
        $this->commonQuery = $commonQuery;
        $this->courseRepository = $courseRepository;
    }

    public function handle(User $instructor): CoordinatorResponse
    {
        $commonResponse = $this->commonQuery->handle($instructor);

        $courses = $this->obtainCoursesThanInstructorCanSee($instructor);

        return new CoordinatorResponse($commonResponse, $courses);
    }

    private function obtainCoursesThanInstructorCanSee(User $instructor): Collection
    {

        $languageIds = $instructor->transformLanguagesToArrayIds();

        $courses = collect();

        foreach ($instructor->university as $university) {

            $universityCourses = $this->courseRepository->obtainCourseFromUniversityByLanguages($university, $languageIds);

            //dd($universityCourses);

            $nuevo = [];

            foreach ($universityCourses as $course) {
                array_push($nuevo, $course->isActive());
                if ($course->isActive() AND !$courses->has($course->id)){
                    $courses->put($course->id, $course);
                }
            }

            //dd($nuevo);
        }

        $courses = $courses->sortBy(function ($course) {
            return $course->university->name.'-'.$course->name;
        });

        return $courses;
    }
}
