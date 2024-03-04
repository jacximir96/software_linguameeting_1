<?php

namespace App\Src\Shared\Repository;

use App\Src\Shared\Service\CriteriaSearch;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class BuilderSpecificDateRepository
{
    private string $searchValue;

    public function buildQuery(Builder $query, CriteriaSearch $criteria, string $fieldDate): Builder
    {

        if (! $criteria->searchBy('specific_date')) {
            return $query;
        }

        $this->searchValue = $criteria->get('specific_date');

        //days
        if ($this->isToday()) {
            $first = Carbon::now()->startOfDay();
            $end = Carbon::now()->endOfDay();
        } elseif ($this->isYesterday()) {
            $first = Carbon::now()->subDay()->startOfDay();
            $end = Carbon::now()->subDay()->endOfDay();
        }

        //weeks
        elseif ($this->isCurrentWeek()) {
            $first = Carbon::now()->startOfWeek();
            $end = Carbon::now()->endOfWeek();
        } elseif ($this->isLastWeek()) {
            $first = Carbon::now()->startOfWeek()->subWeek();
            $end = Carbon::now()->startOfWeek()->subWeek()->endOfWeek();
        }

        //months
        elseif ($this->isCurrentMonth()) {
            $first = Carbon::now()->startOfMonth();
            $end = Carbon::now()->endOfMonth();
            $query->whereBetween($fieldDate, [$first->toDateString(), $end->toDateString()]);
        } elseif ($this->isLastMonth()) {
            $first = Carbon::now()->startOfMonth()->subMonth();
            $end = Carbon::now()->startOfMonth()->subMonth()->endOfMonth();
        }

        //years
        elseif ($this->isCurrentYear()) {
            $first = Carbon::now()->startOfYear();
            $end = Carbon::now()->endOfYear();
        } elseif ($this->isLastYear()) {
            $first = Carbon::now()->startOfYear()->subYear();
            $end = Carbon::now()->startOfYear()->subYear()->endOfYear();
        }

        $query->whereBetween($fieldDate, [$first->toDateTimeString(), $end->toDateTimeString()]);

        return $query;
    }

    private function isToday()
    {
        return $this->searchValue == config('linguameeting.list.search_specific_dates.today.key');
    }

    private function isYesterday()
    {
        return $this->searchValue == config('linguameeting.list.search_specific_dates.yesterday.key');
    }

    private function isCurrentWeek()
    {
        return $this->searchValue == config('linguameeting.list.search_specific_dates.current_week.key');
    }

    private function isLastWeek()
    {
        return $this->searchValue == config('linguameeting.list.search_specific_dates.last_week.key');
    }

    private function isCurrentMonth()
    {
        return $this->searchValue == config('linguameeting.list.search_specific_dates.current_month.key');
    }

    private function isLastMonth()
    {
        return $this->searchValue == config('linguameeting.list.search_specific_dates.last_month.key');
    }

    private function isCurrentYear()
    {
        return $this->searchValue == config('linguameeting.list.search_specific_dates.current_year.key');
    }

    private function isLastYear()
    {
        return $this->searchValue == config('linguameeting.list.search_specific_dates.last_year.key');
    }
}
