<?php

namespace App\Src\CourseDomain\Course\Model;

use Carbon\Carbon;

class CourseTerm
{
    private Carbon $startDate;

    private Carbon $endDate;

    public function __construct(Carbon $startDate, Carbon $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function startDate(): Carbon
    {
        return $this->startDate;
    }

    public function endDate(): Carbon
    {
        return $this->endDate;
    }
}
