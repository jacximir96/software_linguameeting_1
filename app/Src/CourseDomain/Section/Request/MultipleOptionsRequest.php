<?php

namespace App\Src\CourseDomain\Section\Request;

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
            'items_ids' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'items_ids.required' => trans('common_form.required', ['field' => 'courses']),
        ];
    }
}
