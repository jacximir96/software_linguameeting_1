<?php

namespace App\Src\ExperienceDomain\ExperienceRegisterPublic\Request;

use Illuminate\Foundation\Http\FormRequest;

class PublicRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'payment' => 'required',
            'check_terms' => 'required',
            'code' => 'required_if:payment,payEnvivoCode',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => trans('common_form.required', ['field' => 'First Name']),
            'last_name.required' => trans('common_form.required', ['field' => 'Last Name']),
            'email.required' => trans('common_form.required', ['field' => 'Email']),
            'payment.required' => trans('common_form.required', ['field' => 'Payment Option']),
            'check_terms.required' => trans('common_form.required', ['field' => 'Terms and Conditions']),
            'code.required_if' => trans('payment.bookstore_code.required_if'),
        ];
    }

    public function isPaymentWithCode(): bool
    {
        return $this->filled('code');
    }
}
