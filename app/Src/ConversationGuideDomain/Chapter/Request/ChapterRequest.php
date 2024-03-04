<?php

namespace App\Src\ConversationGuideDomain\Chapter\Request;

use Illuminate\Foundation\Http\FormRequest;

class ChapterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('common_form.required', ['field' => 'name']),
        ];
    }
}
