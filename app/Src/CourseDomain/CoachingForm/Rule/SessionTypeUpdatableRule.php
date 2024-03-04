<?php

namespace App\Src\CourseDomain\CoachingForm\Rule;

use App\Src\ConversationPackageDomain\SessionType\Model\SessionType;
use App\Src\CourseDomain\CoachingForm\Request\CourseInformationRequest;
use Illuminate\Contracts\Validation\Rule;

class SessionTypeUpdatableRule implements Rule
{
    private CourseInformationRequest $request;

    public function __construct(CourseInformationRequest $request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        $course = $this->request->course;

        if ($course->hasStudents()) {
            $sessionTypeCurrent = $course->conversationPackage->sessionType;

            $sessionTypeSelected = SessionType::find($value);

            if ($sessionTypeCurrent->isSmallGroup() and $sessionTypeSelected->isOneAndOne()) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return trans('coaching_form.session_type_blocked');
    }
}
