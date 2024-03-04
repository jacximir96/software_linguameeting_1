<?php

namespace App\Src\CourseDomain\CoachingForm\Rule;

use App\Src\CourseDomain\CoachingForm\Request\CoachingWeeksRequest;
use App\Src\CourseDomain\Course\Model\Course;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class MakeUpWeekSelectedAreValidRule implements Rule
{
    private CoachingWeeksRequest $request;

    private Course $course;

    private string $message = '';

    public function __construct(CoachingWeeksRequest $request, Course $course)
    {
        $this->request = $request;
        $this->course = $course;
    }

    public function passes($attribute, $value)
    {
        if ($this->request->isFlexSelected()) {
            return true;
        }

        if (! $this->request->hasMakeUpSelected()) {
            return true;
        }

        if (! $this->isDatesWeelFilled()) {
            return false;
        }

        if (! $this->checkDatesAreValid()) {
            return false;
        }

        return true;
    }

    private function isDatesWeelFilled(): bool
    {
        $startDateFilled = $this->request->filled('startDateMake');
        $dueDateNotFilled = is_null($this->request->dueDateMake);

        if ($startDateFilled and $dueDateNotFilled) {
            $this->message = sprintf('The makeup dates must be filled in.');

            return false;
        }

        $startDateNotFilled = is_null($this->request->startDateMake);
        $dueDateFilled = $this->request->filled('dueDateMake');

        if ($startDateNotFilled and $dueDateFilled) {
            $this->message = sprintf('The makeup dates must be filled in.');

            return false;
        }

        return true;
    }

    private function checkDatesAreValid(): bool
    {
        $courseDates = $this->course->period();
        $startDate = Carbon::parse($this->request->startDateMake);
        $dueDate = Carbon::parse($this->request->dueDateMake);

        if ($startDate->greaterThan($dueDate)) {
            $this->message = sprintf('The makeup dates are not in order. Please check the makeup date fields.');

            return false;
        }

        if (! $startDate->between($courseDates->getStartDate(), $courseDates->getEndDate())) {
            $this->message = sprintf('The make-up dates chosen are not within the course period selected. Please correct their dates.');

            return false;
        }

        if (! $dueDate->between($courseDates->getStartDate(), $courseDates->getEndDate())) {
            $this->message = sprintf('The make-up dates chosen are not within the course period selected. Please correct their dates.');

            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->message;
    }
}
