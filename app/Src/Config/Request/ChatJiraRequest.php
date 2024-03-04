<?php

namespace App\Src\Config\Request;

use Illuminate\Foundation\Http\FormRequest;

class ChatJiraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_chat_at' => 'required_with:end_chat_at',
            'end_chat_at' => 'required_with:start_chat_at',

        ];
    }

    public function messages()
    {
        return [];
    }
}
