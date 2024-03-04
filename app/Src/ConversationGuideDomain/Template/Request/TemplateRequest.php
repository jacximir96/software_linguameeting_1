<?php

namespace App\Src\ConversationGuideDomain\Template\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class TemplateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'description' => 'required',
        ];

        $isCreate = (Route::current()->getName() == 'post.admin.config.conversation_guide.template.create');

        if ($isCreate) {
            $rules['template_file'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'description.required' => trans('common_form.required', ['field' => 'name']),
        ];
    }
}
