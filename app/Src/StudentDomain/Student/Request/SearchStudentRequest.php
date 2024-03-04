<?php

namespace App\Src\StudentDomain\Student\Request;

use Illuminate\Foundation\Http\FormRequest;

class SearchStudentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            //
        ];
    }

    public function searchDesactive(): bool
    {
        return (bool) $this->desactive;
    }
}
