<?php

namespace App\Src\CoachDomain\Ranking\Request;

use Illuminate\Foundation\Http\FormRequest;

class RankingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //'value' => 'required',
        ];
    }

    public function messages()
    {
        return [
            //'value.required' => trans('common_form.required', ['field' => 'value']),
        ];
    }
}
