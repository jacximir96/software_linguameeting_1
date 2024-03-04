<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard\Presenter;

trait SectionOpenable
{
    protected int $forcedOpenSectionId = 0;

    public function setForcedOpenSectionId(int $sectionId)
    {
        $this->forcedOpenSectionId = $sectionId;
    }

    public function sectionToExpand(int $sectionId): bool
    {
        if ($this->forcedOpenSectionId) {
            return $this->forcedOpenSectionId == $sectionId;
        }

        if ($this->sections()->count() == 1) {
            return true;
        }

        return false;
    }
}
