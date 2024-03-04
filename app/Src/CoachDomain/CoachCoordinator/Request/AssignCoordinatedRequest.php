<?php

namespace App\Src\CoachDomain\CoachCoordinator\Request;

use Illuminate\Foundation\Http\FormRequest;

class AssignCoordinatedRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'coach_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'coach_id.required' => trans('common_form.required', ['field' => 'coach']),
        ];
    }
}
