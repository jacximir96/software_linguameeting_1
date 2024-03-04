<?php

namespace App\Src\UserDomain\User\Request;

use Illuminate\Foundation\Http\FormRequest;

class SearchAutocompleteRequest extends FormRequest
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
}
