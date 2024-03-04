<?php

namespace App\Src\Survey\Request;

use Illuminate\Foundation\Http\FormRequest;

class SurveyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'required',
            'url' => 'required|url',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => trans('common_form.required', ['field' => 'Description']),
            'url.required' => trans('common_form.required', ['field' => 'Url']),
        ];
    }
}
