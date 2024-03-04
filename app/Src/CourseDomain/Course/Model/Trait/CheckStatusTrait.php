<?php
namespace App\Src\CourseDomain\Course\Model\Trait;

use Carbon\Carbon;


trait CheckStatusTrait
{

    public function isActive(): bool
    {
        $referenceEndDate = $this->end_date->addWeeks(2);

        if ($referenceEndDate->isPast()) {
            return false;
        }

        if ($this->section->count()) {
            return true;
        }

        if ( ! $this->isFlex()) {
            return (bool) $this->coachingWeek->count();
        }

        return false;
    }

    public function isLingro(): bool
    {
        return $this->is_lingro;
    }

    public function isFlex(): bool
    {
        return $this->is_flex;
    }


}
