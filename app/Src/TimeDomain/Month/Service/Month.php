<?php

namespace App\Src\TimeDomain\Month\Service;

use App\Src\TimeDomain\Month\Exception\NumberMonthIsInvalid;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class Month
{
    private int $month;

    private int $year;

    public function __construct(int $month, int $year)
    {

        $this->month = $month;
        $this->year = $year;

        $this->checkMonth($month);

    }

    public function month(): int
    {
        return $this->month;
    }

    public function year(): int
    {
        return $this->year;
    }

    public function period(): CarbonPeriod
    {

        $start = Carbon::parse('01-'.$this->month.'-'.$this->year);
        $end = $start->clone()->endOfMonth();

        return new CarbonPeriod($start, $end);
    }

    public function monthWithZero(): string
    {
        return str_pad($this->month, 2, '0', STR_PAD_LEFT);
    }

    private function checkMonth(int $month)
    {

        if ($month < 1) {
            throw new NumberMonthIsInvalid();
        }

        if ($month > 12) {
            throw new NumberMonthIsInvalid();
        }
    }
}
