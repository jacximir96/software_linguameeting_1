<?php

namespace App\Src\InstructorDomain\Instructor\Request;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFullInstructorRequest extends FormRequest implements FullInstructorRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|unique:user,email,'.$this->instructor->id,
            'country_id' => 'required',
            'timezone_id' => 'required',
            'role_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('common_form.required', ['field' => 'name']),
            'lastname.required' => trans('common_form.required', ['field' => 'lastname']),
            'email.required' => trans('common_form.required', ['field' => 'email']),
            'email.unique' => trans('validation.unique', ['attribute' => 'email']),
            'country_id.required' => trans('common_form.required', ['field' => 'country']),
            'timezone_id.required' => trans('common_form.required', ['field' => 'time zone']),
            'university_id.required' => trans('common_form.required', ['field' => 'university']),
            'role_id.required' => trans('common_form.required', ['field' => 'role']),
        ];
    }
}
