<?php

namespace App\Src\InstructorDomain\TeachingAssistant\Request;

use Illuminate\Foundation\Http\FormRequest;

class AssignInstructorToAssistantRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'instructor_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'instructor_id.required' => trans('common_form.required', ['field' => 'instructor']),
        ];
    }
}
