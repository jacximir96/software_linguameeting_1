<?php

namespace App\Src\CoachDomain\Course\Request;

use Illuminate\Foundation\Http\FormRequest;

class SearchCourseRequest extends FormRequest
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
