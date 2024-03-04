<?php

namespace App\Src\CourseDomain\CoachingForm\Rule;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GuideRule implements Rule
{
    private FormRequest $request;

    public function __construct(FormRequest $request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        if (! $this->request->filled('user_lingro')) {
            return true;
        }

        $isUserLingro = (bool) $this->request->user_lingro;

        if ($isUserLingro) {
            if ((is_numeric($value)) and ($value > 0)) {
                //user selected a guide
                return true;
            }

            return false;
        }

        return true;
    }

    public function message()
    {
        return trans('common_form.required', ['field' => 'guide']);
    }
}
