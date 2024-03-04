<?php

namespace App\Src\CourseDomain\Course\Request;

use Illuminate\Foundation\Http\FormRequest;

class CourseBasicRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'level_id' => 'required',
            'student_class' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'level_id.required' => trans('common_form.required', ['field' => 'level']),
            'num_students.required' => trans('common_form.required', ['field' => 'expected students per class']),
        ];
    }
}
