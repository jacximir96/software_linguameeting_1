<?php

namespace App\Src\ExperienceDomain\Experience\Model;

use App\Src\Localization\TimeZone\Model\TimeZone;
use Carbon\Carbon;

trait Time
{
    public function startTime(): Carbon
    {
        return $this->start;
    }

    public function endTime(): Carbon
    {
        return $this->end;
    }

    public function startTimeWithoutSeconds(): string
    {
        return date('H:i', strtotime($this->start_time));
    }

    public function endTimeWithoutSeconds(): string
    {
        return date('H:i', strtotime($this->end_time));
    }

    public function isFuture(Carbon $now)
    {
        return $this->start->greaterThan($now);
    }
}
