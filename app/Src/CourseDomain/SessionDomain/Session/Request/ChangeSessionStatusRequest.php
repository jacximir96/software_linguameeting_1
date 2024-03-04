<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Request;

use Illuminate\Foundation\Http\FormRequest;

class ChangeSessionStatusRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'session_status_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'session_status_id.required' => trans('common_form.required', ['field' => 'session status']),
        ];
    }
}
