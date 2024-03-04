<?php

namespace App\Src\StudentRole\BookSession\Request;

use Illuminate\Foundation\Http\FormRequest;

class SearchCoachRequest extends FormRequest implements BookSessionRequest
{
    use BookSessionRequestable;

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'dateSession' => 'required',
            'time_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'dateSession.required' => trans('common_form.required', ['field' => 'Date']),
            'time_id.required' => trans('common_form.required', ['field' => 'Time']),
        ];
    }
}
