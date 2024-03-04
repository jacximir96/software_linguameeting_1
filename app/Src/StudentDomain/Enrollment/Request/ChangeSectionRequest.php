<?php

namespace App\Src\StudentDomain\Enrollment\Request;

use App\Src\CourseDomain\Section\Service\SectionCode;
use Illuminate\Foundation\Http\FormRequest;

class ChangeSectionRequest extends FormRequest
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
            'code.exists' => trans('payment.section_code.exists_v2'),
        ];
    }

    public function sectionCode(): SectionCode
    {
        return new SectionCode($this->code);
    }
}
