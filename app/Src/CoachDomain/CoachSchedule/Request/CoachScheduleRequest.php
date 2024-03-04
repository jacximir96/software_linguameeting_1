<?php

namespace App\Src\CoachDomain\CoachSchedule\Request;

use App\Src\Localization\TimeZone\Model\TimeZone;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Http\FormRequest;

class CoachScheduleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        return [
            'start_time.*' => 'required|string',
            'end_time.*' => 'required',
            'apply_dates' => 'required',
            'day_week' => 'required_if:apply_dates,apply_week_date',

            'start_date' => 'required_if:apply_dates,apply_week_date|required_if:apply_dates,apply_period',
            'end_date' => 'required_if:apply_dates,apply_week_date|required_if:apply_dates,apply_period',
        ];
    }

    public function messages()
    {
        return [
            'start_time.required' => trans('common_form.required', ['field' => 'Start Time']),
            'end_time.required' => trans('common_form.required', ['field' => 'End Time']),

            'apply_dates.required' => trans('common_form.required', ['field' => 'Apply Dates']),
            'day_week.required_if' => 'Es obligatorio indicar al menos un día de la semana.',

            'start_date.required_if' => trans('common_form.required_if', ['field_one' => 'Start Date', 'field_two' => 'Apply To All Dates']),
            'end_date.required_if' => trans('common_form.required_if', ['field_one' => 'End Date', 'field_two' => 'Apply To All Dates']),
        ];
    }

    public function isUpdate(): bool
    {
        return $this->action == 'update';
    }

    public function isDelete(): bool
    {
        return $this->action == 'delete';
    }

    public function isApplyToDay(): bool
    {
        return $this->apply_dates == 'apply_only_day';
    }

    public function isApplyToSameDayWeek(): bool
    {
        return $this->apply_dates == 'apply_week_date';
    }

    public function isApplyToPeriod(): bool
    {
        return $this->apply_dates == 'apply_period';
    }

    public function period(): CarbonPeriod
    {

        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);

        return new CarbonPeriod($startDate, $endDate);
    }

    public function periodFromTimezone(TimeZone $timeZone): CarbonPeriod
    {

        $startDate = Carbon::parse($this->start_date.' '.$this->start_time[0] , $timeZone->name)->setTimezone('UTC');
        $endDate = Carbon::parse($this->end_date.' '.$this->end_time[0] , $timeZone->name)->setTimezone('UTC');

        return new CarbonPeriod($startDate, $endDate);
    }

    public function createSlots(): array
    {

        $intevals = [];

        foreach ($this->start_time as $key => $hour) {
            $endHour = $this->end_time[$key];
            $interval = [
                'start' => $this->date.' '.$hour.':00',
                'end' => $this->date.' '.$endHour.':00',
            ];
            $intevals[] = $interval;
        }

        return $intevals;
    }

    public function hasDayOfWeek(int $dayOfWeek): bool
    {

        if (! isset($this->day_week)) {
            return false;
        }

        return in_array($dayOfWeek, $this->day_week);
    }

    public function applyHoursOff(): bool
    {
        return $this->apply_hours_off;
    }
}
