<?php

namespace App\Src\ExperienceDomain\Experience\Request;

use Illuminate\Foundation\Http\FormRequest;

class ExperienceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'day' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'language_id' => 'required',
            'level_id' => 'required',
            'coach_id' => 'required',
            'max_students' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => trans('common_form.required', ['field' => 'name']),
            'description.required' => trans('common_form.required', ['field' => 'description']),
            'day.required' => trans('common_form.required', ['field' => 'day']),
            'start_time.required' => trans('common_form.required', ['field' => 'name']),
            'end_time.required' => trans('common_form.required', ['field' => 'end_timw']),
            'language_id.required' => trans('common_form.required', ['field' => 'language']),
            'level_id.required' => trans('common_form.required', ['field' => 'level']),
            'coach_id.required' => trans('common_form.required', ['field' => 'coach']),
            'max_students.required' => trans('common_form.required', ['field' => 'max students']),

        ];
    }
}
