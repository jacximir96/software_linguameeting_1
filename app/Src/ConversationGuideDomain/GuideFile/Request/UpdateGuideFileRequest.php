<?php

namespace App\Src\ConversationGuideDomain\GuideFile\Request;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGuideFileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'required',

        ];
    }

    public function messages()
    {
        return [
            'description.required' => trans('common_form.required', ['field' => 'name']),
        ];
    }
}
