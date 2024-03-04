<?php

namespace App\Src\CourseDomain\CoachingForm\Rule;

use App\Src\CourseDomain\CoachingForm\Request\CoachingWeeksRequest;
use Illuminate\Contracts\Validation\Rule;

class FlexOptionRule implements Rule
{
    private CoachingWeeksRequest $request;

    public function __construct(CoachingWeeksRequest $request)
    {
        $this->request = $request;

    }

    public function passes($attribute, $value)
    {

        if ($this->request->isFlexSelected()) {
            return true;
        }

        if ($this->request->hasDatesSelected()) {
            return true;
        }

        return false;
    }

    public function message()
    {
        return 'Flex or Sessions Dates are required.';
    }
}
