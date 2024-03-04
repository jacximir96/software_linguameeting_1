<?php

namespace App\Src\UniversityDomain\University\Presenter;

use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UniversityDomain\University\Repository\UniversityRepository;
use Illuminate\Support\Collection;

class ShowUniversityPresenter
{
    private UniversityRepository $universityRepository;

    private CourseRepository $courseRepository;

    public function __construct(UniversityRepository $universityRepository, CourseRepository $courseRepository)
    {
        $this->universityRepository = $universityRepository;
        $this->courseRepository = $courseRepository;
    }

    public function handle(University $university): ShowUniversityViewData
    {
        $university->load($this->universityRepository->relations());

        $activeCourses = $this->obtainActiveCourses($university);

        return new ShowUniversityViewData($university, $activeCourses);
    }

    public function obtainActiveCourses(University $university): Collection
    {
        $activeCourses = collect();

        $allCourses = $this->courseRepository->obtainCourseFromUniversity($university);

        foreach ($allCourses as $course) {
            if ($course->isActive()) {
                $activeCourses->push($course);
            }
        }

        return $activeCourses;
    }
}
