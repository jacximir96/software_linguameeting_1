<?php

namespace App\Src\CourseDomain\CoachingFormExperiences\Presenter;

use Carbon\Carbon;

interface CourseSummary
{
    public function endDate(): Carbon;

    public function hasEndDate(): bool;

    public function hasStartDate(): bool;

    public function isCourse(): bool;

    public function startDate(): Carbon;

    public function universityName(): string;
}
