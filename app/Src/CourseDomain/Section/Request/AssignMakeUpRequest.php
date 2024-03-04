<?php

namespace App\Src\CourseDomain\Section\Request;

use App\Src\StudentDomain\Makeup\Request\MakeupRequest;
use Illuminate\Foundation\Http\FormRequest;

class AssignMakeUpRequest extends FormRequest implements MakeupRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'number_makeups' => 'required|numeric|min:1',
            'is_free' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'number_makeups.required' => trans('common_form.required', ['field' => 'make-up sessions']),
            'is_free.required' => trans('common_form.required', ['field' => 'type']),
        ];
    }
}
