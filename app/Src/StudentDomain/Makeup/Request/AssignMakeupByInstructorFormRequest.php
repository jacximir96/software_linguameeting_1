<?php

namespace App\Src\StudentDomain\Makeup\Request;

use Illuminate\Foundation\Http\FormRequest;

class AssignMakeupByInstructorFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'num_makeups' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'num_makeups.required' => trans('common_form.required', ['field' => 'num_makeups']),
        ];
    }
}
