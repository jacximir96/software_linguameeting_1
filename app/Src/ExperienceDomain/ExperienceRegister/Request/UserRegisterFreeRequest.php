<?php

namespace App\Src\ExperienceDomain\ExperienceRegister\Request;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterFreeRequest extends FormRequest implements RegisterExperienceRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }
}
