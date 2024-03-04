<?php

namespace App\Src\StudentDomain\Enrollment\Request;

use App\Src\CourseDomain\Section\Service\SectionCode;
use Illuminate\Foundation\Http\FormRequest;

class AdditionalEnrollmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'payment' => 'required',
            'check_terms' => 'required',
            'code' => 'required_if:payment,payEnvivoCode',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => trans('common_form.required', ['field' => 'Code']),
            'code.exists' => trans('payment.section_code.exists'),
            'check_terms.required' => trans('common_form.required', ['field' => 'Terms and Conditions']),
            'code.required_if' => trans('payment.bookstore_code.required_if'),
        ];
    }

    public function sectionCode(): SectionCode
    {
        return new SectionCode($this->code);
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
