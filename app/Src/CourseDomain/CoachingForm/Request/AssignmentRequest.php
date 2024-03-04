<?php

namespace App\Src\CourseDomain\CoachingForm\Request;

use Illuminate\Foundation\Http\FormRequest;

class AssignmentRequest extends FormRequest implements GuideRequest
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

    public function applyToAllSections(): bool
    {

        return $this->action == 'to_all_sections';
    }

    public function applyToCurrentSection(): bool
    {
        return $this->action == 'current_section';
    }
}
