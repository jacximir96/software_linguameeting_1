<?php

namespace App\Src\CoachDomain\SalaryDomain\IncentiveType\Request;

use Illuminate\Foundation\Http\FormRequest;

class IncentiveTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('common_form.required', ['field' => 'Name']),
        ];
    }
}
