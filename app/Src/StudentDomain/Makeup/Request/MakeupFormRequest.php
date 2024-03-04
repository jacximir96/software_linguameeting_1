<?php

namespace App\Src\StudentDomain\Makeup\Request;

use Illuminate\Foundation\Http\FormRequest;

class MakeupFormRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'is_free' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'is_free.required' => trans('common_form.required', ['field' => 'free o payd']),
        ];
    }
}
