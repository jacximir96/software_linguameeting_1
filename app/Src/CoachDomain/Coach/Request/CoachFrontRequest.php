<?php
namespace App\Src\CoachDomain\Coach\Request;

use App\Src\UserDomain\Password\Service\PasswordService;
use App\Src\UserDomain\User\Rule\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class CoachFrontRequest extends FormRequest implements ICoachRequest
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
            'email' => 'required|email|unique:user,email',
            'password' => ['required', new PasswordRule($this, new PasswordService())],
            'country_id' => 'required',
            'timezone_id' => 'required',
            'language_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => trans('common_form.required', ['field' => 'First Name']),
            'lastname.required' => trans('common_form.required', ['field' => 'Last Name']),
            'email.required' => trans('common_form.required', ['field' => 'Email Address']),
            'password.required' => trans('common_form.required', ['field' => 'Password']),
            'country_id.required' => trans('common_form.required', ['field' => 'Country']),
            'timezone_id.required' => trans('common_form.required', ['field' => 'Time Zone']),
            'language_id.required' => trans('common_form.required', ['field' => 'Language']),
        ];
    }

    public function language(): array
    {
        return [$this->language_id];
    }
}
