<?php

namespace App\Src\CourseDomain\CoachingForm\Request;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentForSmallGroupRequest extends FormRequest implements GuideRequest
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
}
