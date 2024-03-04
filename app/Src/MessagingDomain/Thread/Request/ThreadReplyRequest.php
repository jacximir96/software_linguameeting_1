<?php

namespace App\Src\MessagingDomain\Thread\Request;

use Illuminate\Foundation\Http\FormRequest;

class ThreadReplyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'content.required' => trans('common_form.required', ['field' => 'content']),
        ];
    }
}
