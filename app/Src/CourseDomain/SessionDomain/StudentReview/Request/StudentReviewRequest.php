<?php

namespace App\Src\CourseDomain\SessionDomain\StudentReview\Request;

use Illuminate\Foundation\Http\FormRequest;

class StudentReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'is_attended' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'is_attended.required' => trans('common_form.required', ['field' => 'Session Attended']),
        ];
    }

    public function isAttended(): bool
    {

        return (bool) $this->is_attended;

    }
}
