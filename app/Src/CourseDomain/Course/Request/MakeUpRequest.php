<?php

namespace App\Src\CourseDomain\Course\Request;

use Illuminate\Foundation\Http\FormRequest;

class MakeUpRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'number_makeups' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'number_makeups.required' => trans('common_form.required', ['field' => 'make-up sessions']),
        ];
    }
}
