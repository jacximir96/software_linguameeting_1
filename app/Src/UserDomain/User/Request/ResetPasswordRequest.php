<?php

namespace App\Src\UserDomain\User\Request;

use App\Src\UserDomain\Password\Service\PasswordService;
use App\Src\UserDomain\User\Rule\PasswordRule;
use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => [new PasswordRule($this, new PasswordService())],
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
