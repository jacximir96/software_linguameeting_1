<?php

namespace App\Src\UniversityDomain\Instructor\Request;

use App\Src\UniversityDomain\Instructor\Repository\UniversityInstructorRepository;
use App\Src\UniversityDomain\Instructor\Rule\UniversityUniqueRule;
use Illuminate\Foundation\Http\FormRequest;

class AssignUniversityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $universityUniqueForInstructor = new UniversityUniqueRule($this, new UniversityInstructorRepository());

        //dd($universityUniqueForInstructor);

        return [
            'university_id' => ['required', $universityUniqueForInstructor],
        ];
    }

    public function messages()
    {
        return [
            'university_id.required' => trans('common_form.required', ['field' => 'university']),
        ];
    }
}
