<?php

namespace App\Src\CourseDomain\CoachingForm\Rule;

use App\Src\ConversationPackageDomain\Package\Repository\ConversationPackageRepository;
use App\Src\CourseDomain\CoachingForm\Request\CoachingWeeksRequest;
use App\Src\CourseDomain\Course\Model\Course;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class WeeksSelectedAreValidRule implements Rule
{
    private CoachingWeeksRequest $request;

    private ConversationPackageRepository $conversationPackageRepository;

    private Course $course;

    private string $message = '';

    public function __construct(CoachingWeeksRequest $request, Course $course, ConversationPackageRepository $conversationPackageRepository)
    {
        $this->request = $request;
        $this->course = $course;
        $this->conversationPackageRepository = $conversationPackageRepository;
    }

    public function passes($attribute, $value)
    {
        if ($this->request->isFlexSelected()) {
            return true;
        }

        if ($this->request->areDatesIncomplete()) {
            if (is_null($value)) { //este if nos sirve únicamente para mostrar el error en las fechas que faltan
                $this->message = sprintf('Please complete missing session dates.');

                return false;
            }

            return true;
        }

        $attribute = explode('.', $attribute);
        $field = $attribute[0];
        $numSession = $attribute[1];

        if (! $this->checkDatesAreValid($field, $numSession, $value)) {
            return false;
        }

        return true;
    }

    private function checkDatesAreValid($field, $numSession, $value): bool
    {
        $startDates = collect($this->request->startDateSession);
        $dueDates = collect($this->request->dueDateSession);

        if ((is_null($startDates->get($numSession))) and is_null($dueDates->get($numSession))) {
            //if session is not filled...return true;
            return true;
        }

        //check than start and duedate of sessino is filled
        if ($field == 'startDateSession') {
            if (is_null($dueDates->get($numSession))) {
                $this->message = sprintf('Please complete missing session dates.');

                return false;
            }
        } else {
            if (is_null($startDates->get($numSession))) {
                $this->message = sprintf('Please complete missing session dates.');

                return false;
            }
        }

        $startDate = Carbon::parse($startDates->get($numSession));
        $dueDate = Carbon::parse($dueDates->get($numSession));

        $courseDates = $this->course->period();
        $startDate = Carbon::parse($startDate);

        if ($field == 'startDateSession') {
            if ($startDates->get($numSession) > $dueDates->get($numSession)) {
                $this->message = sprintf('The dates are not in order. Please check the date fields.');

                return false;
            }
        }

        if (! $startDate->between($courseDates->getStartDate(), $courseDates->getEndDate())) {
            $this->message = sprintf('The session dates are outside the course period previously selected. Please select your sessions during the correct dates.');

            return false;
        }

        $dueDate = Carbon::parse($dueDate);
        if (! $dueDate->between($courseDates->getStartDate(), $courseDates->getEndDate())) {
            $this->message = sprintf('The session dates are outside the course period selected. You must schedule your coaching weeks during the course period');

            return false;
        }

        return true;
    }

    public function message()
    {
        return $this->message;
    }
}
