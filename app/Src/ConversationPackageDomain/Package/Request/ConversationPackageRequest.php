<?php

namespace App\Src\ConversationPackageDomain\Package\Request;

use Illuminate\Foundation\Http\FormRequest;

class ConversationPackageRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'session_type_id' => 'required',
            'name' => 'required',
            'number_session' => 'required|numeric|min:1',
            'duration_session' => 'required|numeric|min:15',
            'isbn' => 'required',
            'price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'session_type_id.required' => trans('common_form.required', ['field' => 'Session Type']),
            'name.required' => trans('common_form.required', ['field' => 'Name']),
            'number_session.required' => trans('common_form.required', ['field' => 'Number Session']),
            'duration_session.required' => trans('common_form.required', ['field' => 'Duration Session']),
            'isbn.required' => trans('common_form.required', ['field' => 'ISBN']),
            'price.required' => trans('common_form.required', ['field' => 'Price']),
        ];
    }
}
