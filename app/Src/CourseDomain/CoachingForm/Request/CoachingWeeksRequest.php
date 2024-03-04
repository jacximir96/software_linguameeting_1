<?php

namespace App\Src\CourseDomain\CoachingForm\Request;

use App\Src\ConversationPackageDomain\Package\Repository\ConversationPackageRepository;
use App\Src\CourseDomain\CoachingForm\Rule\FlexOptionRule;
use App\Src\CourseDomain\CoachingForm\Rule\MakeUpWeekSelectedAreValidRule;
use App\Src\CourseDomain\CoachingForm\Rule\WeeksSelectedAreValidRule;
use App\Src\TimeDomain\Date\Service\WeekCalendar;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Foundation\Http\FormRequest;

class CoachingWeeksRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $flexOptionRule = new FlexOptionRule($this);
        $weeksSelectedAreValidRule = new WeeksSelectedAreValidRule($this, $this->course, new ConversationPackageRepository());
        $makeUpWeeksSelectedAreValidRule = new MakeUpWeekSelectedAreValidRule($this, $this->course);

        return [
            //'is_flex' => [$flexOptionRule],
            'startDateSession.*' => [$weeksSelectedAreValidRule],
            'dueDateSession.*' => [$weeksSelectedAreValidRule],
            'startDateMake' => [$makeUpWeeksSelectedAreValidRule],
        ];
    }

    public function messages()
    {
        return [
            'is_flex.required' => trans('common_form.required', ['field' => 'title']),

        ];
    }

    public function weekCalendar(): WeekCalendar
    {
        $weekCalendar = new WeekCalendar();

        $startDates = collect($this->startDateSession);
        $dueDates = collect($this->dueDateSession);

        foreach ($startDates as $numSession => $startDate) {
            $startDate = Carbon::parse($startDate);
            $dueDate = Carbon::parse($dueDates->get($numSession));
            $period = new CarbonPeriod($startDate, $dueDate);

            $weekCalendar->add($period);
        }

        return $weekCalendar;
    }

    public function isFlexSelected(): bool
    {
        return (bool) $this->is_flex;
    }

    public function numberOfWeeksSelected(): int
    {
        return collect($this->startDateSession)->count();
    }

    public function isNoDateSelected(): bool
    {

        foreach ($this->startDateSession as $numSession => $date) {

            $thereIsStartDate = ! is_null($date);
            if ($thereIsStartDate) {
                return false;
            }

            $thereIsEndDate = ! is_null($this->dueDateSession[$numSession]);
            if ($thereIsEndDate) {
                return false;
            }
        }

        return true;
    }

    public function areDatesIncomplete(): bool
    {
        if ($this->hasDatesSelected()) {
            return false;
        }

        return true;
    }

    //all dates selected
    public function hasDatesSelected(): bool
    {

        foreach ($this->startDateSession as $numSession => $date) {

            if (is_null($date)) {
                return false;
            }

            if (! isset($this->dueDateSession[$numSession])) {
                return false;
            }

            if (is_null($this->dueDateSession[$numSession])) {
                return false;
            }
        }

        return true;
    }


    public function hasMakeUpSelected(): bool
    {
        return $this->filled('startDateMake') and $this->filled('dueDateMake');
    }
}
