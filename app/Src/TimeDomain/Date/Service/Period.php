<?php

namespace App\Src\TimeDomain\Date\Service;

use App\Src\Localization\TimeZone\Model\TimeZone;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Period
{
    const DAYS_WEEK = 7;

    private CarbonPeriod $period;

    public function __construct(CarbonPeriod $period)
    {
        $this->period = $period;
    }

    public function get(): CarbonPeriod
    {
        return $this->period;
    }

    public function contains(Carbon $day): bool
    {
        return $this->period->contains($day);
    }

    public function isPast(Carbon $day):bool{
        return $day->greaterThan($this->period->getEndDate());
    }

    public function key(): string
    {
        $start = $this->period->getStartDate();
        $end = $this->period->getEndDate();

        return $start->toDateString().'_'.$end->toDateString();
    }

    public function writePeriod(): string
    {
        $start = $this->period->getStartDate();
        $end = $this->period->getEndDate();

        return $start->format('m/d/Y').' - '.$end->format('m/d/Y');
    }

    public function subDayFromStart(): Carbon
    {
        return $this->period->getStartDate()->subDay()->startOfDay();
    }

    public function hasPrevPage(int $page): bool
    {
        return $page > 1;
    }

    public function hasNextPage(int $page): bool
    {
        return $page < $this->pages();
    }

    public function pages(): int
    {

        return (int) ceil($this->period->count() / self::DAYS_WEEK);
    }

    public function forPage(int $page)
    {

        if ($page < 1) {
            $page = 1;
        }

        $pages = $this->pages();
        if ($page > $pages) {
            $page = $pages;
        }

        $fechas = collect($this->period->toArray())->forPage($page, self::DAYS_WEEK);

        return new CarbonPeriod($fechas->first(), $fechas->last());
    }

    public function print(): string
    {
        return $this->period->getStartDate()->toDatetimeString().' - '.$this->period->getEndDate()->toDateTimeString();
    }
}
