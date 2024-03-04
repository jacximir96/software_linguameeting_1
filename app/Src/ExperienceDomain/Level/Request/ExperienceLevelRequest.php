<?php

namespace App\Src\ExperienceDomain\Level\Request;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceLevelRequest extends FormRequest
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
            'description.required' => trans('common_form.required', ['field' => 'Name']),
        ];
    }
}
