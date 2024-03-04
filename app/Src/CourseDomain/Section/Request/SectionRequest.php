<?php

namespace App\Src\CourseDomain\Section\Request;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'instructor_id' => 'required',
            'name' => 'required',
            'num_students' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('common_form.required', ['field' => 'name']),
            'instructor_id.required' => trans('common_form.required', ['field' => 'instructor']),
            'num_students.required' => trans('common_form.required', ['field' => 'expected students per class']),
        ];
    }
}
