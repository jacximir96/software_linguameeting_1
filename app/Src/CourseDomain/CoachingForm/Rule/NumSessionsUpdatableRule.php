<?php

namespace App\Src\CourseDomain\CoachingForm\Rule;

use App\Src\CourseDomain\CoachingForm\Request\CourseInformationRequest;
use Illuminate\Contracts\Validation\Rule;

class NumSessionsUpdatableRule implements Rule
{
    private CourseInformationRequest $request;

    public function __construct(CourseInformationRequest $request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        if ($this->request->isCreateCourse()) {
            return true;
        }

        $course = $this->request->course;

        if ($course->hasStudents()) {
            if (! $course->conversationPackage->isEqualNumberOfSession($value)) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return trans('coaching_form.num_sessions_blocked');
    }
}
