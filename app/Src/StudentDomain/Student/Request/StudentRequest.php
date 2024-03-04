<?php

namespace App\Src\StudentDomain\Student\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class StudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'country_id' => 'required',
            'timezone_id' => 'required',
        ];

        $isCreate = (Route::current()->getName() == 'post.admin.student.create');
        if ($isCreate) {
            $rules['email'] = 'required|unique:user,email';
        } else {
            $rules['email'] = 'required|unique:user,email,'.$this->student->id;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => trans('common_form.required', ['field' => 'name']),
            'lastname.required' => trans('common_form.required', ['field' => 'lastname']),
            'email.required' => trans('common_form.required', ['field' => 'email']),
            'email.unique' => trans('validation.unique', ['attribute' => 'email']),
            'country_id.required' => trans('common_form.required', ['field' => 'country origin']),
            'timezone_id.required' => trans('common_form.required', ['field' => 'time zone']),
        ];
    }
}
