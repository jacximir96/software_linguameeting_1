<?php

namespace App\Src\CourseDomain\CourseCoordinator\Request;

use Illuminate\Foundation\Http\FormRequest;

class ChangeCourseCoordinatorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }

    public function hasCourseCoordinatorSelect(): bool
    {
        return $this->filled('instructor_id');
    }
}
