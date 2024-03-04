<?php

namespace App\Http\Controllers\Api\Options\Course;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Course\Repository\CourseRepository;
use App\Src\CourseDomain\Course\Request\MultipleOptionsRequest;

class MultipleController extends Controller
{
    private CourseRepository $courseRepository;

    public function __construct(CourseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function __invoke(MultipleOptionsRequest $request)
    {
        try {
            $universitiesIds = collect($request->universities_ids);

            $courses = $this->courseRepository->obtainCourseFromMultipleUniversities($universitiesIds)

            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                ];
            });

            return response()->json(['items' => $courses], 200);
        } catch (\Throwable $exception) {
            return response(['message' => 'Error loading courses from universities.'], 500);
        }
    }
}
