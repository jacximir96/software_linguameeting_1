<?php

namespace App\Src\CourseDomain\CourseCoordinator\Request;

use Illuminate\Foundation\Http\FormRequest;

class AssignMultipleCoursesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'course_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'course_id.required' => trans('common_form.required', ['field' => 'course']),
        ];
    }

    public function hasCourseCoordinatorSelect(): bool
    {
        return $this->filled('instructor_id');
    }
}
