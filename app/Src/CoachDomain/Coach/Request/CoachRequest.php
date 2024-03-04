<?php

namespace App\Src\CoachDomain\Coach\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class CoachRequest extends FormRequest implements ICoachRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'name' => 'required',
            'lastname' => 'required',
            'country_id' => 'required',
            'country_live_id' => 'required',
            'timezone_id' => 'required',
            'language' => 'required',
            'role_id' => 'required',
        ];

        $isCreate = (Route::current()->getName() == 'post.admin.coach.create');
        if ($isCreate) {
            $rules['email'] = 'required|unique:user,email';
        } else {
            $rules['email'] = 'required|unique:user,email,'.$this->coach->id;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => trans('common_form.required', ['field' => 'name']),
            'lastname.required' => trans('common_form.required', ['field' => 'lastname']),
            'email.required' => trans('common_form.required', ['field' => 'email']),
            'email.unique' => trans('validation.unique', ['attribute' => 'email']),
            'country_id.required' => trans('common_form.required', ['field' => 'country origin']),
            'country_live_id.required' => trans('common_form.required', ['field' => 'country live']),
            'timezone_id.required' => trans('common_form.required', ['field' => 'time zone']),
            'university_id.required' => trans('common_form.required', ['field' => 'university']),

            'language_id.required' => trans('common_form.required', ['field' => 'language']),
            'role_id.required' => trans('common_form.required', ['field' => 'role']),
        ];
    }

    public function language(): array
    {
        return $this->language;
    }
}
