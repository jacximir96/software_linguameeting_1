<?php

namespace App\Src\ExperienceDomain\Experience\Request;

use Illuminate\Foundation\Http\FormRequest;

class InstructorSearchExperienceRequest extends FormRequest
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

    public function sanitizeQuery ():string{

        if ($this->filled('query')){
            return trim($this->get('query'));
        }

        return '';
    }
}
