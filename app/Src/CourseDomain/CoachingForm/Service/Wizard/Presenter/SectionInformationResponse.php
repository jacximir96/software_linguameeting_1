<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

use Illuminate\Support\Collection;

class SectionInformationResponse
{
    use SectionOpenable;

    private Collection $sections;

    public function __construct(Collection $sectionsEditable)
    {
        $this->sections = $sectionsEditable;
    }

    public function sectionsEditable(): Collection
    {
        return $this->sections;
    }

    public function sections(): Collection
    {
        return $this->sections;
    }
}
