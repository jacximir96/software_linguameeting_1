<?php

namespace App\Src\CourseDomain\Assignment\Request;

use Illuminate\Foundation\Http\FormRequest;

class FormAssignmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $maxSize = config('linguameeting.files.max_upload_size_in_KB');

        return [
            'file' => 'file|max:'.$maxSize,
        ];
    }

    public function messages()
    {
        return [
            'file.max' => 'File size is exceeded.',
        ];
    }

    public function saveAllSessions(): bool
    {
        return $this->action == 'save-all-sessions';
    }
}
