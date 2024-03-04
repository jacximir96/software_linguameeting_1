<?php

namespace App\Src\TimeDomain\Date\Service;

use Carbon\CarbonPeriod;

class PaginatorPeriod
{
    const DAYS_WEEK = 7;

    private CarbonPeriod $period;

    public function __construct(CarbonPeriod $period)
    {

        $this->period = $period;
    }

    public function hasPrevPage(int $page): bool
    {
        return $page > 1;
    }

    public function hasNextPage(int $page): bool
    {
        return $page < $this->pages();
    }

    public function hasNavigator(int $page):bool{
        return ($this->hasPrevPage($page) OR $this->hasNextPage($page));
    }

    public function pages(): int
    {

        return (int) ceil($this->period->count() / self::DAYS_WEEK);
    }

    public function forPage(int $page):CarbonPeriod
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
}
