<?php

namespace App\Src\CourseDomain\Holiday\Model;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class HolidaysDates
{
    private Collection $dates;

    public function __construct()
    {
        $this->dates = collect();
    }

    public function get(): Collection
    {
        return $this->dates;
    }

    public function push(Carbon $date)
    {
        $this->dates->push($date);
    }
}
