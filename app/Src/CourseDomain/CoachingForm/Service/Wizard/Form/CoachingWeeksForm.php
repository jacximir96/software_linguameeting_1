<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Form;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class CoachingWeeksForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function allowsFullEdition(Course $course, User $user): bool
    {
        return $course->allowsFullEdition($user);
    }

    public function hideWeeks(Course $course): bool
    {

        if (old('_token') === null) {
            if ($course->isFlex()) {
                return true;
            }

            return false;
        }

        if (old('is_flex')) {
            return true;
        }

        return false;
    }

    public function config(Course $course)
    {
        $this->course = $course;

        $this->action = route('post.admin.course.coaching_form.coaching_weeks', $course);

        $this->model = [];

        if ($course->isFlex()) {
            $this->configFlexModel($course);
        } else {
            $this->configWeekDatesModel($course);
        }
    }

    private function configFlexModel(Course $course)
    {
        $this->model['is_flex'] = true;
    }

    private function configWeekDatesModel(Course $course)
    {
        $weeks = $course->coachingWeek->sortBy('session_order');

        foreach ($weeks as $week) {
            if ($week->isMakeup()) {
                $this->model['startDateMake'] = $week->start_date->toDateString();
                $this->model['dueDateMake'] = $week->end_date->toDateString();
            } else {
                $this->model['startDateSession'][$week->session_order] = $week->start_date->toDateString();
                $this->model['dueDateSession'][$week->session_order] = $week->end_date->toDateString();
            }
        }
    }
}
