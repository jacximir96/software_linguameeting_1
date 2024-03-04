<?php

namespace App\Src\ExperienceDomain\Experience\Request;

use Illuminate\Foundation\Http\FormRequest;

class PublicTipRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'amount' => 'required|numeric',
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:user,email',
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => trans('common_form.required', ['field' => 'Amount']),
            'name.required' => trans('common_form.required', ['field' => 'Name']),
            'lastname.required' => trans('common_form.required', ['field' => 'Last Name']),
            'email.required' => trans('common_form.required', ['field' => 'Email']),
        ];
    }
}
