<?php

namespace App\Src\UniversityDomain\Instructor\Request;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUniversityRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'university_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'university_id.required' => trans('common_form.required', ['field' => 'university']),
        ];
    }
}
