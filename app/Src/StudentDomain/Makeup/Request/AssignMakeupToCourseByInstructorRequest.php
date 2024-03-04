<?php

namespace App\Src\StudentDomain\Makeup\Request;

use Illuminate\Foundation\Http\FormRequest;

class AssignMakeupToCourseByInstructorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'number_makeups' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'number_makeups.required' => trans('common_form.required', ['field' => 'Make-ups numbers']),
        ];
    }
}
