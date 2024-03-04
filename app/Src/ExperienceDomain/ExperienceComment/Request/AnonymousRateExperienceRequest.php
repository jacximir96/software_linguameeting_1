<?php

namespace App\Src\ExperienceDomain\ExperienceComment\Request;

use App\Src\ExperienceDomain\ExperienceComment\Model\ExperienceComment;
use Illuminate\Foundation\Http\FormRequest;

class AnonymousRateExperienceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:user,email',
            'comment' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'name.required' => trans('common_form.required', ['field' => 'First Name']),
            'lastname.required' => trans('common_form.required', ['field' => 'Last Name']),
            'email.required' => trans('common_form.required', ['field' => 'Email']),
            'comment.required' => trans('common_form.required', ['field' => 'Comment']),
        ];
    }

    public function rate(): int
    {

        if ($this->filled('rate')) {
            return $this->rate;
        }

        return ExperienceComment::DEFAULT_RATE;
    }
}
