<?php

namespace App\Src\StudentDomain\StudentHelp\Request;

use Illuminate\Foundation\Http\FormRequest;

class StudentHelpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'student_help_type_id' => 'required',
            'description' => 'required',
            'url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'student_help_type_id.required' => trans('common_form.required', ['field' => 'type']),
            'description.required' => trans('common_form.required', ['field' => 'description']),
            'url.required' => trans('common_form.required', ['field' => 'url']),
        ];
    }
}
