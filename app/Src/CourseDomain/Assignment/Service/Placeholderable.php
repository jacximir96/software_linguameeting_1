<?php

namespace App\Src\CourseDomain\Assignment\Service;

use App\Src\CourseDomain\Section\Model\Section;

trait Placeholderable
{
    public function namePlaceholder(Section $section): string
    {

        if ($section->course->language->isMajority()) {
            return trans('coaching_form.course_assignments.placeholder.majority_language.name');
        }

        return trans('coaching_form.course_assignments.placeholder.minority_language.name');

    }

    public function descriptionPlaceholder(Section $section): string
    {

        if ($section->course->language->isMajority()) {
            return trans('coaching_form.course_assignments.placeholder.majority_language.description');
        }

        return trans('coaching_form.course_assignments.placeholder.minority_language.description');

    }
}
