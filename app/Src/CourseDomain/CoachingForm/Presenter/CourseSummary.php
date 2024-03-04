<?php

namespace App\Src\CourseDomain\CoachingForm\Presenter;

use Carbon\Carbon;
use Illuminate\Support\Collection;

interface CourseSummary
{
    public function endDate(): Carbon;

    public function hasEndDate(): bool;

    public function hasHolidays(): bool;

    public function hasStartDate(): bool;

    public function holidays(): Collection;

    public function isCourse(): bool;

    public function startDate(): Carbon;

    public function withExperience(): bool;

    public function universityName(): string;
}
