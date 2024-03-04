<?php

namespace App\Src\CourseDomain\CoachingFormExperiences\Request;

use Illuminate\Foundation\Http\FormRequest;

class AcademicDatesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'semester_id' => 'required',
            'year' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'language_id' => 'required',
            'experience_type_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('common_form.required', ['field' => 'academic course title']),
            'semester_id.required' => trans('common_form.required', ['field' => 'term']),
            'year.required' => trans('common_form.required', ['field' => 'year']),
            'start_date.required' => trans('common_form.required', ['field' => 'start date']),
            'end_date.required' => trans('common_form.required', ['field' => 'end date']),
            'end_date.after' => 'The end date must be after the selected start date.',
            'experience_type_id' => trans('common_form.required', ['field' => 'experiences']),
        ];
    }

    public function hasDiscount(): bool
    {
        return is_numeric($this->discount);
    }
}
