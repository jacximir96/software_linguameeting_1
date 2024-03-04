<?php

namespace App\Src\CoachDomain\SalaryDomain\Salary\Request;

use Illuminate\Foundation\Http\FormRequest;

class SalaryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'salary_type_id' => 'required',
            'value' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'salary_type_id.required' => trans('common_form.required', ['field' => 'Type']),
            'value.required' => trans('common_form.required', ['field' => 'Salary']),
        ];
    }
}
