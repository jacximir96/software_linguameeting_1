<?php

namespace App\Src\StudentRole\BookSession\Request;

use Illuminate\Foundation\Http\FormRequest;

class ShowCoachRequest extends FormRequest implements BookSessionRequest
{
    use BookSessionRequestable;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'coach_id' => 'required',
            'date' => 'required',
            'time_hour_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'coach_id.required' => trans('common_form.required', ['field' => 'Coach']),
            'date.required' => trans('common_form.required', ['field' => 'Date']),
            'time_hour_id.required' => trans('common_form.required', ['field' => 'Time Hour']),
        ];
    }
}
