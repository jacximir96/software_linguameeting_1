<?php

namespace App\Src\ExperienceDomain\Experience\Request;

use Illuminate\Foundation\Http\FormRequest;

class TipRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => trans('common_form.required', ['field' => 'Amount']),
        ];
    }
}
