<?php

namespace App\Src\TimeDomain\Date\Service;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class Periods
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

    public function addPeriod(Period $period)
    {
        $this->periods->push($period);
    }

    public function convertToOptions(): array
    {

        $options = [];

        foreach ($this->periods as $period) {
            $options[$period->key()] = $period->writePeriod();
        }

        return $options;
    }

    public function nearToDate(Carbon $date): ?Period
    {

        $current = $this->findForDateOrNull($date);

        if ($current) {
            return $current;
        }

        foreach ($this->periods as $period) {
            if ($period->get()->getStartDate()->greaterThan($date)) {
                return $period;
            }
        }

        return $this->periods->first();
    }

    public function findForDateOrNull(Carbon $date): ?Period
    {

        foreach ($this->periods as $period) {
            if ($period->contains($date)) {
                return $period;
            }
        }

        return null;
    }

    public function nextPeriods(Carbon $day):self{

        $periods = new self();

        foreach ($this->periods as $period){

            if ($period->isPast($day)){
                continue;
            }

            if ($period->contains($day)){
                continue;
            }

            $periods->addPeriod($period);
        }

        return $periods;
    }
}
