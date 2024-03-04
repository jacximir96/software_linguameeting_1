<?php

namespace App\Src\UniversityDomain\University\Request;

use Illuminate\Foundation\Http\FormRequest;

class SearchUniversityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
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
