<?php

namespace App\Src\TimeDomain\Date\Service;

use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class WeekCalendar
{
    private Collection $periods;

    public function __construct()
    {
        $this->periods = collect();
    }

    public function get(): Collection
    {
        return $this->periods;
    }

    public function add(CarbonPeriod $period)
    {
        $this->periods->push($period);
    }
}
