<?php

namespace App\Src\StudentDomain\Student\Request;

use App\Src\CourseDomain\Section\Service\SectionCode;
use App\Src\UserDomain\Password\Service\PasswordService;
use App\Src\UserDomain\User\Rule\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class StudentRegisterPersonalDataRequest extends FormRequest
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
            'email' => 'required|email|confirmed|unique:user,email',
            'password' => ['required', new PasswordRule($this, new PasswordService())],
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
            'email.required' => trans('common_form.required', ['field' => 'Email Address']),
            'password.required' => trans('common_form.required', ['field' => 'Password']),
            'payment.required' => trans('common_form.required', ['field' => 'Payment Option']),
            'check_terms.required' => trans('common_form.required', ['field' => 'Terms and Conditions']),
            'code.required_if' => trans('payment.bookstore_code.required_if'),
        ];
    }

    public function code(): SectionCode
    {
        return new SectionCode($this->code);
    }

    public function isCodePayment(): bool
    {
        return $this->filled('code');
    }

    public function isFreePayment(): bool
    {
        return $this->filled('payment') and ($this->payment == 'payFree');
    }

    public function isCreditCardPayment(): bool
    {
        return $this->filled('payment') and ($this->payment == 'brainTree');
    }
}
