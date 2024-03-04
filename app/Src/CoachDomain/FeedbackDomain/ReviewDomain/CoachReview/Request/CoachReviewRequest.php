<?php

namespace App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Request;

use Illuminate\Foundation\Http\FormRequest;

class CoachReviewRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        //dd($this->all());

        return [
            'rate' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'rate.required' => trans('common_form.required', ['field' => 'Rate']),
        ];
    }
}
