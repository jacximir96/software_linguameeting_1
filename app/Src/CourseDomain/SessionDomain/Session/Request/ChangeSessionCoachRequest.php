<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Request;

use Illuminate\Foundation\Http\FormRequest;

class ChangeSessionCoachRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'coach_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'coach_id.required' => trans('common_form.required', ['field' => 'Coach']),
        ];
    }
}
