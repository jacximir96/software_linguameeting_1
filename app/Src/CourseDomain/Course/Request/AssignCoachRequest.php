<?php

namespace App\Src\CourseDomain\Course\Request;

use Illuminate\Foundation\Http\FormRequest;

class AssignCoachRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'coach_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'coach_id.required' => trans('common_form.required', ['field' => 'coach']),
        ];
    }
}
