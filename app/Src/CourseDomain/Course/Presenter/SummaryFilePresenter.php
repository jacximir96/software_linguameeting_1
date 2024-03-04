<?php

namespace App\Src\CourseDomain\Course\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use Carbon\CarbonPeriodImmutable;

class SummaryFilePresenter
{
    private Course $course;

    public function handle(Course $course): SummaryFileResponse
    {
        $this->course = $course;

        $period = $this->obtainPeriod();

        return new SummaryFileResponse($this->course, $period);
    }

    private function obtainPeriod(): CarbonPeriodImmutable
    {
        if ($this->course->isFlex()) {
            return $this->obtainDefaultPeriod();
        }

        return $this->obtainCoachingWeeksdates();
    }

    private function obtainCoachingWeeksdates(): CarbonPeriodImmutable
    {
        if ($this->course->coachingWeek->count()) {
            $coachingWeeks = $this->course->coachingWeek->sortBy(function ($coachingWeek) {
                return $coachingWeek->start_date->toDateString();
            });

            $startDate = $coachingWeeks->first()->start_date;
            $endDate = $coachingWeeks->last()->end_date;

            return new CarbonPeriodImmutable($startDate, $endDate);
        }

        return $this->obtainDefaultPeriod();
    }

    private function obtainDefaultPeriod(): CarbonPeriodImmutable
    {
        $startDate = $this->course->start_date;
        $endDate = $this->course->end_date;

        return new CarbonPeriodImmutable($startDate, $endDate);
    }
}
