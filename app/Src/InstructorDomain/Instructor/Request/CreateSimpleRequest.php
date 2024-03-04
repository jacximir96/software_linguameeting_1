<?php

namespace App\Src\InstructorDomain\Instructor\Request;

use Illuminate\Foundation\Http\FormRequest;

class CreateSimpleRequest extends FormRequest implements BasicInstructorRequest
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
            'email' => 'required|unique:user,email,',
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
            'role_id.required' => trans('validation.required', ['attribute' => 'role']),
        ];
    }
}
