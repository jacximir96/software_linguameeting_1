<?php

namespace App\Src\CourseDomain\Course\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use Carbon\CarbonPeriodImmutable;
use Illuminate\Support\Collection;

class SummaryFileResponse
{
    private Course $course;

    private CarbonPeriodImmutable $period;

    public function __construct(Course $course, CarbonPeriodImmutable $period)
    {
        $this->course = $course;
        $this->period = $period;
    }

    public function course(): Course
    {
        return $this->course;
    }

    public function period(): CarbonPeriodImmutable
    {
        return $this->period;
    }

    public function isLingro(): bool
    {
        return $this->course->isLingro();
    }

    public function isFlex(): bool
    {
        return $this->course->isFlex();
    }

    public function hasBuyMakeups(): bool
    {
        return $this->course->buy_makeups;
    }

    public function printBuyMakeups(): string
    {

        if (! $this->hasBuyMakeups()) {
            return 'None';
        }

        return $this->course->printMakeupsNumber();
    }

    public function hasHolidays(): bool
    {
        return $this->course->holiday->count();
    }

    public function holidays(): Collection
    {
        if (! $this->course->holiday->count()) {
            return collect();
        }

        return collect($this->course->holiday)
            ->map(function ($holiday) {
                return $holiday->date;
            });
    }
}
