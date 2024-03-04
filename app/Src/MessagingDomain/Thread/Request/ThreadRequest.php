<?php

namespace App\Src\MessagingDomain\Thread\Request;

use Illuminate\Foundation\Http\FormRequest;

class ThreadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'participant_id' => 'required',
            'subject' => 'required',
            'content' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'participant_id.required' => trans('common_form.required', ['field' => 'participants']),
            'subject.required' => trans('common_form.required', ['field' => 'subject']),
            'content.required' => trans('common_form.required', ['field' => 'content']),
        ];
    }
}
