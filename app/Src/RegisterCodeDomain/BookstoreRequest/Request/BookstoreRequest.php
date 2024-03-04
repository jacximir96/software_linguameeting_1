<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Request;

use Illuminate\Foundation\Http\FormRequest;

class BookstoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'university_id' => 'required',
            'number_codes' => 'required',
            'course_type_id' => 'required_without:experience_course_type_id',
            'experience_course_type_id' => 'required_without:course_type_id',
        ];
    }

    public function messages()
    {
        return [
            'university_id.required' => trans('common_form.required', ['field' => 'university']),
            'number_codes.required' => trans('common_form.required', ['field' => 'number of codes']),
            'course_type_id.required_without' => trans('common_form.required_without', ['field_one' => 'Linguameeting codes', 'field_two' => 'Linguameeting codes + Experiences']),
        ];
    }

    public function isExperiencesSelected(): bool
    {
        return $this->filled('experience_course_type_id');
    }
}
