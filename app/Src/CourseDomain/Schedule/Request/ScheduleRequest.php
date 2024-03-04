<?php

namespace App\Src\CourseDomain\Schedule\Request;

use App\Src\TimeDomain\Date\Service\Period;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'period' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'period.required' => trans('common_form.required', ['field' => 'week']),
        ];
    }

    public function periodSelected(): Period
    {

        $week = explode('_', $this->period);

        $startDate = Carbon::parse($week[0]);
        $endDate = Carbon::parse($week[1]);

        $carbonPeriod = new CarbonPeriod($startDate, $endDate);

        return new Period($carbonPeriod);
    }
}
