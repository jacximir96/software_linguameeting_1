<?php

namespace App\Http\Controllers\Api\Options\Section;

use App\Http\Controllers\Controller;
use App\Src\CourseDomain\Section\Repository\SectionRepository;
use App\Src\CourseDomain\Section\Request\MultipleOptionsRequest;

class MultipleController extends Controller
{
    private SectionRepository $sectionRepository;

    public function __construct(SectionRepository $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function __invoke(MultipleOptionsRequest $request)
    {
        try {
            $coursesIds = collect($request->items_ids);

            $sections = $this->sectionRepository->obtainCourseFromMultipleCourses($coursesIds)

            ->map(function ($section) {
                return [
                    'id' => $section->id,
                    'name' => $section->name,
                ];
            });

            return response()->json(['items' => $sections], 200);
        } catch (\Throwable $exception) {
            return response(['message' => 'Error loading sections from courses.'], 500);
        }
    }
}
