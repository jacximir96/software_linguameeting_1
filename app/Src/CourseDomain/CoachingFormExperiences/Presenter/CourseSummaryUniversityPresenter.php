<?php

namespace App\Src\CourseDomain\CoachingFormExperiences\Presenter;

use App\Src\UniversityDomain\University\Model\University;
use Carbon\Carbon;

class CourseSummaryUniversityPresenter implements CourseSummary
{
    private University $university;

    public function __construct(University $university)
    {
        $this->university = $university;
    }

    public function universityName(): string
    {
        return $this->university->name;
    }

    public function startDate(): Carbon
    {
        return Carbon::now();
    }

    public function endDate(): Carbon
    {
        return Carbon::now();
    }

    public function hasEndDate(): bool
    {
        return false;
    }

    public function hasStartDate(): bool
    {
        return false;
    }

    public function isCourse(): bool
    {
        return false;
    }
}
