<?php

namespace App\Src\CourseDomain\Course\Request;

use Illuminate\Foundation\Http\FormRequest;

class MultipleOptionsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'universities_ids' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'universities_ids.required' => trans('common_form.required', ['field' => 'university']),
        ];
    }
}
