<?php

namespace App\Src\UserDomain\User\Request;

use App\Src\CoachDomain\Coach\Request\ICoachRequest;
use App\Src\UserDomain\Password\Service\PasswordService;
use App\Src\UserDomain\User\Rule\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class CoachProfileRequest extends FormRequest implements ICoachRequest
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
            'country_id' => 'required',
            'timezone_id' => 'required',

            'email' => 'required|unique:user,email,'.user()->id,
            'email_reception' => 'required',
            'email_marketing' => 'required',

            'password' => [new PasswordRule($this, new PasswordService())],

            'country_live_id' => 'required',
            'language_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('common_form.required', ['field' => 'name']),
            'lastname.required' => trans('common_form.required', ['field' => 'lastname']),

            'country_id.required' => trans('common_form.required', ['field' => 'country']),
            'timezone_id.required' => trans('common_form.required', ['field' => 'time zone']),

            'email.required' => trans('common_form.required', ['field' => 'email']),
            'email.unique' => trans('validation.unique', ['attribute' => 'email']),

            'email_reception' => trans('common_form.required', ['field' => 'email reception']),
            'email_marketing' => trans('common_form.required', ['field' => 'email marketing']),

            'country_live_id.required' => trans('common_form.required', ['field' => 'country live']),
            'timezone_id.required' => trans('common_form.required', ['field' => 'time zone']),
        ];
    }

    public function language(): array
    {
        return [$this->language_id];
    }
}
