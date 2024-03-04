<?php

namespace App\Src\UniversityDomain\University\Request;

use Illuminate\Foundation\Http\FormRequest;

class UniversityRequest extends FormRequest
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
            'name' => 'required',
            'country_id' => 'required',
            'timezone_id' => 'required',
            'university_level_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('common_form.required', ['field' => 'name']),
            'country_id.required' => trans('common_form.required', ['field' => 'country']),
            'timezone_id.required' => trans('common_form.required', ['field' => 'time zone']),
            'university_level_id.required' => trans('common_form.required', ['field' => 'level']),
        ];
    }
}
