<?php

namespace App\Src\StudentRole\GoogleCalendar\Request;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Http\FormRequest;

class GenerateGoogleCalendarRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'start_date' => 'required',
            'end_date' => 'required',
        ];

    }

    public function messages()
    {
        return [
            'start_date.required' => trans('common_form.required', ['field' => 'Start Date']),
            'end_date.required' => trans('common_form.required', ['field' => 'End Date']),
        ];
    }

    public function period(): CarbonPeriod
    {
        $startDate = Carbon::parse($this->start_date)->startOfDay();
        $endDate = Carbon::parse($this->end_date)->endOfDay();

        return new CarbonPeriod($startDate->toDatetimeString(), $endDate->toDatetimeString());
    }
}
