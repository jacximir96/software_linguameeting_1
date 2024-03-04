<?php

namespace App\Src\CourseDomain\CoachingForm\Request;

use App\Src\CourseDomain\CoachingForm\Rule\CourseInstructorRule;
use App\Src\CourseDomain\CoachingForm\Rule\LingroUserRule;
use App\Src\CourseDomain\CoachingForm\Rule\UniversityInstructorRule;
use Illuminate\Foundation\Http\FormRequest;

class StartRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        if (user()->isInstructor()){

            $universityInstructorRule = app(UniversityInstructorRule::class);
            $rules =  [
                'university_id' => [$universityInstructorRule],
            ];


            if ($this->filled('course_id')){
                //editando un curso ->comprobamos que el usuario es propietario
                $courseInstructorRule = app(CourseInstructorRule::class);
                $rules['course_id'] = [$courseInstructorRule];
            }

            return $rules;
        }

        return [
            'university_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'university_id.required' => trans('common_form.required', ['field' => '']),
        ];
    }

    public function isCoachingFormForLiveExperiences(): bool
    {
        return $this->action == 'live-experiences';
    }

    public function isCoachingFormForCombined(): bool
    {
        return $this->action == 'combined';
    }
}
