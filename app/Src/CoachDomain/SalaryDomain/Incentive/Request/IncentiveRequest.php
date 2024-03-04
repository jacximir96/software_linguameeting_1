<?php

namespace App\Src\CoachDomain\SalaryDomain\Incentive\Request;

use Illuminate\Foundation\Http\FormRequest;

class IncentiveRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'value' => 'required|numeric',
            'date' => 'required|date',
            'type_id' => 'required',
            'frequency_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'value.required' => trans('common_form.required', ['field' => 'Cost']),
            'date.required' => trans('common_form.required', ['field' => 'Date']),
            'type_id.required' => trans('common_form.required', ['field' => 'Type']),
            'frequency_id.required' => trans('common_form.required', ['field' => 'Frequency']),

        ];
    }
}
