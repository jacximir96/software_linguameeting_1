<?php

namespace App\Http\Controllers\Api\Options\Course;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\UniversityDomain\University\Model\University;

class IndexController extends Controller
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function __invoke(University $university)
    {
        $courses = $this->courseRepository->obtainCourseFromUniversity($university, 'name', 'asc')->map(function ($course) {
            return [
                'id' => $course->id,
                'name' => $course->name,
            ];
        });

        return response()->json(['items' => $courses]);
    }
}
