<?php

namespace App\Src\CourseDomain\Section\Presenter;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\Section\Model\Section;
use Carbon\CarbonPeriodImmutable;

class InstructionsResponse
{
    private Section $section;

    private CarbonPeriodImmutable $period;

    public function __construct(Section $section, CarbonPeriodImmutable $period)
    {
        $this->section = $section;
        $this->period = $period;
    }

    public function section(): Section
    {
        return $this->section;
    }

    public function course(): Course
    {
        return $this->section->course;
    }

    public function period(): CarbonPeriodImmutable
    {
        return $this->period;
    }

    public function isLingro(): bool
    {
        return $this->section->course->isLingro();
    }

    public function isFlex(): bool
    {
        return $this->section->course->isFlex();
    }

    public function hasBuyMakeups(): bool
    {
        return $this->section->course->buy_makeups;
    }
}
