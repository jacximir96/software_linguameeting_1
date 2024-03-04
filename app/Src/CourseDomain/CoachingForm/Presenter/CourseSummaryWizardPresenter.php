<?php

namespace App\Src\CourseDomain\CoachingForm\Presenter;

use App\Src\CourseDomain\CoachingForm\Service\Wizard\Wizard;
use App\Src\UniversityDomain\University\Model\University;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CourseSummaryWizardPresenter implements CourseSummary
{
    private Wizard $wizard;

    private ?University $university = null;

    public function __construct(Wizard $wizard)
    {
        $this->wizard = $wizard;
    }

    public function universityName(): string
    {
        if (is_null($this->university)) {
            $this->university = University::find($this->wizard->universityId());
        }

        return $this->university->name;
    }

    public function endDate(): Carbon
    {
        return Carbon::parse($this->wizard->endDate());
    }

    public function withExperience(): bool
    {
        return $this->wizard->withExperience();
    }

    public function hasEndDate(): bool
    {
        return $this->wizard->hasEndDate();
    }

    public function hasHolidays(): bool
    {
        return count($this->wizard->holidays());
    }

    public function hasStartDate(): bool
    {
        return $this->wizard->hasStartDate();
    }

    public function holidays(): Collection
    {
        if (! $this->hasHolidays()) {
            return collect();
        }

        return collect(($this->wizard->holidays()))
            ->map(function ($date) {
                return Carbon::parse($date);
            });
    }

    public function isCourse(): bool
    {
        return false;
    }

    public function startDate(): Carbon
    {
        return Carbon::parse($this->wizard->startDate());
    }
}
