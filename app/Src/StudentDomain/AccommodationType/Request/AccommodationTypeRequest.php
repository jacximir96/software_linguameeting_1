<?php

namespace App\Src\StudentDomain\AccommodationType\Request;

use Illuminate\Foundation\Http\FormRequest;

class AccommodationTypeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'description' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'description.required' => trans('common_form.required', ['field' => 'Description']),
        ];
    }
}
