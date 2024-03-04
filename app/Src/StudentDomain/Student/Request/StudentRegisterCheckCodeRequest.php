<?php

namespace App\Src\StudentDomain\Student\Request;

use App\Src\CourseDomain\Section\Service\SectionCode;
use Illuminate\Foundation\Http\FormRequest;

class StudentRegisterCheckCodeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|exists:section,code',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => trans('common_form.required', ['field' => 'Code']),
            'code.exists' => trans('payment.section_code.public.register.not_exists'),
        ];
    }

    public function sectionCode(): SectionCode
    {
        return new SectionCode($this->code);
    }
}
