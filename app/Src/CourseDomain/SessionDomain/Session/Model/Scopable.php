<?php
namespace App\Src\CourseDomain\SessionDomain\Session\Model;

use App\Src\Localization\TimeZone\Model\TimeZone;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;


trait Scopable
{
    public function scopeFilterLess(Builder $builder, Carbon $moment, string $comparisonSign = '<'): void
    {
        $builder->select('session.*');
        $builder->whereRaw("CONCAT(session.day, ' ', session.start_time) {$comparisonSign} '{$moment->toDateTimeString()}'");
    }

    public function scopeFilterGreater(Builder $builder, Carbon $moment, string $comparisonSign = '>'): void
    {
        $builder->select('session.*');
        $builder->whereRaw("CONCAT(session.day, ' ', session.start_time) {$comparisonSign} '{$moment->toDateTimeString()}'");
    }

    public function scopefilterPeriod(Builder $builder, CarbonPeriod $period): void
    {
        $builder->select('session.*');
        $builder->whereRaw("CONCAT(session.day, ' ', session.start_time) >= '{$period->getStartDate()->toDateTimeString()}'");
        $builder->whereRaw("CONCAT(session.day, ' ', session.end_time) <= '{$period->getEndDate()->toDateTimeString()}'");
    }
}
