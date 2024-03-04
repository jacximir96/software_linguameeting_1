<?php

namespace App\Src\CoachDomain\CoachCoordinator\Request;

use Illuminate\Foundation\Http\FormRequest;

class ChangeCoordinatorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'coordinator_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'coordinator_id.required' => trans('common_form.required', ['field' => 'Coordinator']),
        ];
    }
}
