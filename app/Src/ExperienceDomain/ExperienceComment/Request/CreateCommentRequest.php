<?php

namespace App\Src\ExperienceDomain\ExperienceComment\Request;

use App\Src\ExperienceDomain\ExperienceComment\Model\ExperienceComment;
use Illuminate\Foundation\Http\FormRequest;

class CreateCommentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'comment' => 'required',
        ];
    }

    public function messages()
    {
        return [
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
