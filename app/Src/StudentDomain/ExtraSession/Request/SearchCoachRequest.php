<?php

namespace App\Src\StudentDomain\ExtraSession\Request;

use App\Src\StudentRole\BookSession\Request\BookSessionRequest;
use App\Src\StudentRole\BookSession\Request\BookSessionRequestable;
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
