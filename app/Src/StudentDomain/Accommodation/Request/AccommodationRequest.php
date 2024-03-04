<?php

namespace App\Src\StudentDomain\Accommodation\Request;

use Illuminate\Foundation\Http\FormRequest;

class AccommodationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'accommodation_type_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'accommodation_type_id.required' => trans('common_form.required', ['field' => 'Accommodation Type']),
        ];
    }
}
