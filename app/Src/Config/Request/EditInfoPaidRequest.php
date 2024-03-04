<?php

namespace App\Src\Config\Request;

use Illuminate\Foundation\Http\FormRequest;

class EditInfoPaidRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'paid_info' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'paid_info.required' => trans('common_form.required', ['field' => 'Info Paid']),
        ];
    }
}
