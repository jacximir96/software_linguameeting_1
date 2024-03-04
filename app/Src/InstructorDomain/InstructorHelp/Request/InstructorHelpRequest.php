<?php

namespace App\Src\InstructorDomain\InstructorHelp\Request;

use Illuminate\Foundation\Http\FormRequest;

class InstructorHelpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'instructor_help_type_id' => 'required',
            'description' => 'required',
            'url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'instructor_help_type_id.required' => trans('common_form.required', ['field' => 'type']),
            'description.required' => trans('common_form.required', ['field' => 'description']),
            'url.required' => trans('common_form.required', ['field' => 'url']),
        ];
    }
}
