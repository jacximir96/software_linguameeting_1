<?php

namespace App\Src\CoachDomain\CoachSchedule\Presenter;

use Illuminate\Support\Collection;

class ShowCalendarResponse
{
    private Collection $universities;

    public function __construct(Collection $universities)
    {

        $this->universities = $universities;
    }

    public function universities(): Collection
    {
        return $this->universities;
    }

    public function sortedUniversities(): Collection
    {

        return $this->universities->sortBy(function ($viewUniversity) {
            return $viewUniversity->courses()->count();
        });

    }
}
