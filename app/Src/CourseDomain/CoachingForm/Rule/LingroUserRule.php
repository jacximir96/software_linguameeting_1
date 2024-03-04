<?php

namespace App\Src\CourseDomain\CoachingForm\Rule;

use App\Src\Localization\Language\Model\Language;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class LingroUserRule implements Rule
{
    private FormRequest $request;

    public function __construct(FormRequest $request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        if (! $this->request->filled('language_id')) {
            return true;
        }

        $language = Language::find($this->request->language_id);

        if ($language->isLingro()) {
            return $this->request->filled('user_lingro');
        }

        return true;
    }

    public function message()
    {
        return trans('common_form.required', ['field' => 'LingroLearning user']);
    }
}
