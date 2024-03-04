<?php

namespace App\Src\CourseDomain\CoachingForm\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class AcademicDatesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isNewCourse()) {
            return $this->rulesFullEdition();
        }

        if ($this->course->allowsFullEdition(user())) {
            return $this->rulesFullEdition();
        }

        return $this->rulesPartialEdition();
    }

    private function isNewCourse(): bool
    {
        return is_null($this->course);
    }

    private function rulesFullEdition(): array
    {
        $rules = [
            'semester_id' => 'required',
            'year' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ];

        $isCreate = (Route::current()->getName() == 'post.admin.course.coaching_form.create.academic_dates');

        if ($isCreate) {
            $rules['end_date'] = 'required|date|after:start_date|after:today';
        }

        return $rules;
    }

    private function rulesPartialEdition(): array
    {
        return [
            'semester_id' => 'required',
            'year' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'semester_id.required' => trans('common_form.required', ['field' => 'term']),
            'year.required' => trans('common_form.required', ['field' => 'year']),
            'start_date.required' => trans('common_form.required', ['field' => 'start date']),
            'end_date.required' => trans('common_form.required', ['field' => 'end date']),
            'end_date.after' => 'The end date must be after the selected start date.',
        ];
    }

    public function withExperiences(): bool
    {

        if (! $this->has('experience')) {
            return false;
        }

        return $this->experience;
    }
}
