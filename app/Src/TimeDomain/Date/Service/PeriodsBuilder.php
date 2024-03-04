<?php

namespace App\Src\TimeDomain\Date\Service;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\Localization\TimeZone\Model\TimeZone;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PeriodsBuilder
{
    public function buildTodayFromStartToEndFromTimezone(TimeZone $timeZone): CarbonPeriod
    {

        $now = Carbon::now($timeZone->name)->setTimezone('UTC');
        $startTime = $now->clone()->startOfDay();
        $endTime = $now->clone()->endOfDay();

        return CarbonPeriod::create($startTime, $endTime);
    }

    public function fromCourse(Course $course): Periods
    {

        $periods = new Periods();

        foreach ($course->coachingWeeksSortedByDate() as $coachingWeek) {
            $period = new Period($coachingWeek->period());
            $periods->addPeriod($period);
        }

        return $periods;
    }

    public function makeupFromCourse(Course $course): Periods
    {

        $periods = new Periods();

        foreach ($course->coachingWeeksSortedByDate() as $coachingWeek) {

            if ($coachingWeek->isMakeup()){
                $period = new Period($coachingWeek->period());
                $periods->addPeriod($period);
            }
        }

        return $periods;
    }

    //divide el período pasado en períodos semanales de lunes a viernes
    public function fromPeriod(CarbonPeriod $period): Periods
    {

        $periods = new Periods();

        $firstDay = $period->getStartDate()->startOfWeek();
        $lastDate = $period->getEndDate()->endOfWeek();

        while ($firstDay->lte($lastDate)) {

            $from = $firstDay->copy();
            $to = $firstDay->copy()->endOfWeek();

            $carbonPeriod = new CarbonPeriod($from, $to);

            $period = new Period($carbonPeriod);
            $periods->addPeriod($period);

            $firstDay->addWeek();
        }

        return $periods;
    }
}
