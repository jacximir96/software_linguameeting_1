<?php

namespace App\Src\CourseDomain\Section\Presenter;

use App\Src\CourseDomain\Section\Model\Section;
use Carbon\CarbonPeriodImmutable;

class InstructionsPresenter
{
    private Section $section;

    public function handle(Section $section): InstructionsResponse
    {
        $this->section = $section;

        $period = $this->obtainPeriod();

        return new InstructionsResponse($this->section, $period);
    }

    private function obtainPeriod(): CarbonPeriodImmutable
    {
        if ($this->section->course->isFlex()) {
            return $this->obtainDefaultPeriod();
        }

        return $this->obtainCoachingWeeksdates();
    }

    private function obtainCoachingWeeksdates(): CarbonPeriodImmutable
    {
        if ($this->section->course->coachingWeek->count()) {
            $coachingWeeks = $this->section->course->coachingWeek->sortBy(function ($coachingWeek) {
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
        $startDate = $this->section->course->start_date;
        $endDate = $this->section->course->end_date;

        return new CarbonPeriodImmutable($startDate, $endDate);
    }
}
