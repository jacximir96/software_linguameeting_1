<?php

namespace App\Src\CourseDomain\CoachingFormExperiences\Request;

use Illuminate\Foundation\Http\FormRequest;

class SectionInformationRequest extends FormRequest
{
    private $experienceSelectedInPrevStep = false;

    public function setExperienceSelectedInPrevStep(bool $value)
    {
        $this->experienceSelectedInPrevStep = $value;
    }

    public function isExperienceSelectedInPrevStep(): bool
    {
        return $this->experienceSelectedInPrevStep;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if (! $this->course->section->count()) {
            //forzamos el error si no hay sección sen el curso
            return [
                'number_section' => 'required',
            ];
        }

        return [];
    }

    public function messages()
    {
        return [
            'number_section.required' => 'At least one section is required.',
        ];
    }
}
