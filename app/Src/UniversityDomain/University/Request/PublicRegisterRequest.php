<?php
namespace App\Src\UniversityDomain\University\Request;

use App\Src\UserDomain\Password\Service\PasswordService;
use App\Src\UserDomain\Role\Service\FactoryRole;
use App\Src\UserDomain\Role\Service\RoleChecker;
use App\Src\UserDomain\User\Rule\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;


class PublicRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
return [];
        return [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:user,email',
            'password' => ['required', new PasswordRule($this, new PasswordService())],
            'country_id' => 'required',
            'university_id' => 'required',
            'timezone_id' => 'required',
            'rol_id' => 'required',
            'language_id' => 'required',
            'check_terms' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => trans('common_form.required', ['field' => 'First Name']),
            'last_name.required' => trans('common_form.required', ['field' => 'Last Name']),
            'email.required' => trans('common_form.required', ['field' => 'Email Address']),
            'password.required' => trans('common_form.required', ['field' => 'Password']),
            'check_terms.required' => trans('common_form.required', ['field' => 'Terms and Conditions']),
        ];
    }

    public function isCoordinatorRole(){

        $coordinatorRole = FactoryRole::getById($this->rol_id);

        $roleChecker = app(RoleChecker::class);

        return $roleChecker->isCoordinator($coordinatorRole);

    }
}
