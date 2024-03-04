<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Request;

use Illuminate\Foundation\Http\FormRequest;

class CoachFeedbackRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'language_id' => 'required',
            'recording_url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'language_id.required' => trans('common_form.required', ['field' => 'Language']),
            'recording_url.required' => trans('common_form.required', ['field' => 'Recording URL']),
        ];
    }
}
