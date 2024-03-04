<?php

namespace App\Src\ExperienceDomain\ExperienceRegister\Request;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest implements RegisterExperienceRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->experience->isPaidPrivate()) {
            return [
                'amount' => 'required|numeric',
                'payment' => 'required',
                'code' => 'required_if:payment,payEnvivoCode',
            ];
        }

        return [];
    }

    public function messages()
    {
        if ($this->experience->isPaidPrivate()) {
            return [
                'amount.required' => trans('common_form.required', ['field' => 'Amount']),
                'payment.required' => trans('common_form.required', ['field' => 'Payment Option']),
                'code.required_if' => trans('payment.bookstore_code.required_if'),
            ];
        }

        return [];
    }

    public function isPaymentWithCode(): bool
    {
        return $this->filled('code');
    }

    public function isPaymentFree()
    {
        return ! $this->experience->isPaidPrivate();
    }
}
