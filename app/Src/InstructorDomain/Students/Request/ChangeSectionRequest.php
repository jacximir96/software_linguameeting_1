<?php

namespace App\Src\InstructorDomain\Students\Request;

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
            'section_id' => 'required|numeric|exists:section,code',
        ];
    }

    public function messages()
    {
        return [
            'section_id.required' => trans('common_form.required', ['field' => 'Class ID']),
            'section_id.numeric' => trans('common_form.numeric', ['field' => 'Class ID']),
            'section_id.exists' => trans('payment.section_code.exists_v2'),
        ];
    }

    public function sectionCode(): SectionCode
    {
        return new SectionCode($this->section_id);
    }
}
