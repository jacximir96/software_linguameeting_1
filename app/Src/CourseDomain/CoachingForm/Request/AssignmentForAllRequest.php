<?php

namespace App\Src\CourseDomain\CoachingForm\Request;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentForAllRequest extends FormRequest implements GuideRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'section_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'section_id' => 'Section is required',
        ];
    }
}
