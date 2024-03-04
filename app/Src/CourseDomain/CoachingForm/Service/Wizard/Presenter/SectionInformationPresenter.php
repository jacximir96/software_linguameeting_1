<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Service\SectionFormApi;

class SectionInformationPresenter
{
    public function handle(Course $course): SectionInformationResponse
    {
        $sectionsEditable = collect();

        $sections = $course->section->sortBy(function ($section) {
            return $section->name;
        }, SORT_NATURAL | SORT_FLAG_CASE);

        foreach ($sections as $section) {
            $form = app(SectionFormApi::class);
            $form->configToEdit($section);

            $sectionEditable = new SectionEditable($section, $form);

            $sectionsEditable->push($sectionEditable);
        }

        return new SectionInformationResponse($sectionsEditable);
    }
}
