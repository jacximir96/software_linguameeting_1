<?php

namespace App\Src\CourseDomain\Course\Request;

use Illuminate\Foundation\Http\FormRequest;

class AssignMakeUpRequest extends FormRequest implements \App\Src\StudentDomain\Makeup\Request\MakeupRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'number_makeups' => 'required|numeric|min:1',
            'is_free' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'number_makeups.required' => trans('common_form.required', ['field' => 'make-up sessions']),
            'is_free.required' => trans('common_form.required', ['field' => 'type']),
        ];
    }
}
