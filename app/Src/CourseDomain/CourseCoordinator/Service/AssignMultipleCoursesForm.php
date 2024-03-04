<?php

namespace App\Src\CourseDomain\CourseCoordinator\Service;

use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class AssignMultipleCoursesForm extends BaseSearchForm
{
    private Collection $coursesOptions;

    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {

        $this->courseRepository = $courseRepository;
    }

    public function coursesOptions(): Collection
    {
        return $this->coursesOptions;
    }

    public function config(User $instructor)
    {

        $this->action = route('post.admin.instructor.course.assign_multiple', $instructor->hashId());

        $this->model = [];

        $this->configCoursesOptions($instructor->university, $instructor->courseAsCoordinator());
    }

    private function configCoursesOptions(Collection $universities, Collection $coursesToExclude)
    {

        $courses = $this->obtainCoursesFromUniversities($universities);

        $coursesFiltered = $this->removeCoursesInWichInstructorIsAlreadyCoordinator($courses, $coursesToExclude);

        $this->coursesOptions = $this->sortCourses($coursesFiltered);
    }

    private function obtainCoursesFromUniversities(Collection $universities): Collection
    {
        $universityIds = $universities->pluck('id', 'id');

        $courses = $this->courseRepository->obtainCourseFromMultipleUniversities($universityIds, ['university']);

        return $courses;
    }

    private function removeCoursesInWichInstructorIsAlreadyCoordinator(Collection $courses, Collection $coursesToExclude): Collection
    {

        $coursesToExclude = $coursesToExclude->keyBy('id');

        return $courses->filter(function ($course) use ($coursesToExclude) {

            return $course->isActive() AND !$coursesToExclude->has($course->id);
        });
    }

    private function sortCourses(Collection $courses): Collection
    {

        return $courses->sortBy(function ($course) {

            $string = $course->university->name.'-'.$course->name;

            return Str::slug($string);

        }, SORT_NATURAL);

    }
}
