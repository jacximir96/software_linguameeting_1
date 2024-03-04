<?php

namespace App\Src\HelpDomain\Issue\Request;

use Illuminate\Foundation\Http\FormRequest;

class IssueRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'issue_type_id' => 'required',
            'summary' => 'required',
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'issue_type_id.required' => trans('common_form.required', ['field' => 'Issue Type']),
            'summary.required' => trans('common_form.required', ['field' => 'Summary']),
            'description.required' => trans('common_form.required', ['field' => 'Description']),
        ];
    }
}
