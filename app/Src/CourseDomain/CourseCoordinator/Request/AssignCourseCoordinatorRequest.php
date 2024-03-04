<?php

namespace App\Src\CourseDomain\CourseCoordinator\Request;

use Illuminate\Foundation\Http\FormRequest;

class AssignCourseCoordinatorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [

            'coordinator_id' => 'required',
        ];
    }

    public function messages()
    {
        return [

            'coordinator_id.required' => trans('common_form.required', ['field' => 'coordinator']),
        ];
    }
}
