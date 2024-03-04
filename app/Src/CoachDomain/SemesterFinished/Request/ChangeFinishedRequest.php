<?php

namespace App\Src\CoachDomain\SemesterFinished\Request;

use Illuminate\Foundation\Http\FormRequest;

class ChangeFinishedRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'semester_number' => 'required|numeric',
            'is_checked' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'semester_number.required' => trans('common_form.required', ['field' => 'Semester Number']),
            'is_checked.required' => trans('common_form.required', ['field' => 'Value']),
        ];
    }
}
