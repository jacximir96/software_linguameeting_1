<?php

namespace App\Src\UniversityDomain\University\Presenter;

use App\Src\UniversityDomain\University\Model\University;
use Illuminate\Support\Collection;

class ShowUniversityViewData
{
    private University $university;

    private Collection $courses;

    public function __construct(University $university, Collection $courses)
    {
        $this->university = $university;
        $this->courses = $courses;
    }

    public function university(): University
    {
        return $this->university;
    }

    public function courses(): Collection
    {
        return $this->courses;
    }
}
