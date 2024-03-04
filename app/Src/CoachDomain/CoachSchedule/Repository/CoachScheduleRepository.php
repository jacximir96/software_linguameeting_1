<?php

namespace App\Src\CoachDomain\CoachSchedule\Repository;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CoachDomain\CoachSchedule\Service\Occupation;
use App\Src\CoachDomain\CoachSchedule\Service\SlotsUtc;
use App\Src\CoachDomain\CoachSchedule\Service\DateSlot;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\StudentRole\BookSession\Service\Availability\Filter;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class CoachScheduleRepository
{
    public function findSession(User $coach, Carbon $moment)
    {

        return CoachSchedule::query()
            ->where('coach_id', $coach->id)
            ->where('day', $moment->toDateString())
            ->where('start_time', $moment->toTimeString())
            ->first();

    }

    public function obtainAvailabilityForCoachAndPeriodInUtc(User $coach, CarbonPeriod $period)
    {
        $query = CoachSchedule::query()
            ->with($this->relations())
            ->where('coach_id', $coach->id)
            ->whereRaw("CONCAT(coach_schedule.day, ' ', coach_schedule.start_time) >= '{$period->getStartDate()->toDateTimeString()}'")
            ->whereRaw("CONCAT(coach_schedule.day, ' ', coach_schedule.start_time) <= '{$period->getEndDate()->toDateTimeString()}'")
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        return $query;
    }

    public function obtainAvailabilityReserverdForCoachAndPeriod(User $coach, CarbonPeriod $period)
    {

        return CoachSchedule::query()
            ->with($this->calendarRelations())
            ->whereHas('session', function ($query) use ($coach, $period) {
                $query->where('coach_id', $coach->id)
                    ->whereRaw("CONCAT(coach_schedule.day, ' ', coach_schedule.start_time) >= '".$period->getStartDate()->toDateTimeString()."'")
                    ->whereRaw("CONCAT(coach_schedule.day, ' ', coach_schedule.end_time) <= '".$period->getEndDate()->toDateTimeString()."'");
            })
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
    }

    public function obtainAvailabilityForCoachAndSlot(User $coach, DateSlot $slot)
    {
        return CoachSchedule::query()
            ->where('coach_id', $coach->id)
            //->whereBetween('day', [$slot->start()->toDateString(), $slot->end()->toDateString()])
            //->where('start_time', '>=', $slot->start()->toTimeString())
            //->where('end_time', '<=', $slot->end()->toTimeString())
            ->whereRaw("CONCAT(coach_schedule.day, ' ', coach_schedule.start_time) >= '".$slot->start()->toDateTimeString()."'")
            ->whereRaw("CONCAT(coach_schedule.day, ' ', coach_schedule.end_time) <= '".$slot->end()->endOfMinute()->toDateTimeString()."'")
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
    }

    public function obtainOccupationPercentageByCoachAndPeriod(User $coach, CarbonPeriod $period):Occupation{

        $availabilityTotalInSeconds = CoachSchedule::query()
                        ->select('seconds')
                        ->where('coach_id', $coach->id)
                        ->whereNull('session_id')
                        ->where('start_time', '>=', $period->getStartDate()->startOfDay()->toTimeString())
                        ->where('end_time', '<=', $period->getEndDate()->endOfDay()->toTimeString())
                        ->select(\DB::raw('SUM(TIME_TO_SEC(TIMEDIFF(end_time, start_time))) AS seconds'))
                        ->first();

        $sessionTotalInSeconds = CoachSchedule::query()
            ->select('seconds')
            ->where('coach_id', $coach->id)
            ->whereNotNull('session_id')
            ->where('start_time', '>=', $period->getStartDate()->startOfDay()->toTimeString())
            ->where('end_time', '<=', $period->getEndDate()->endOfDay()->toTimeString())
            ->select(\DB::raw('SUM(TIME_TO_SEC(TIMEDIFF(end_time, start_time))) AS seconds'))
            ->first();

        return new Occupation($availabilityTotalInSeconds->seconds ?? 0, $sessionTotalInSeconds->seconds ?? 0);
    }

    public function obtainCoachSchedulesByIds(array $ids)
    {

        return CoachSchedule::query()
            ->whereIn('id', $ids)
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

    }

    /*
     * @return array [
     *      'start'  => 'yyyy-mm-dd hh:mm:ss',
     *      'end' => 'yyyy-mm-dd hh:mm:ss'
     * ]
     */
    public function obtainSlotsTimeExisting(User $coach, SlotsUtc $slotsUtc): Collection
    {
        $startTimeLimit = $slotsUtc->startTimeLimit();
        $endTimeLimit =  $slotsUtc->endTimeLimit();

        $events = CoachSchedule::query()
            ->where('coach_id', $coach->id)
            ->whereRaw("CONCAT(coach_schedule.day, ' ', coach_schedule.start_time) >= '{$startTimeLimit->toDateTimeString()}'")
            ->whereRaw("CONCAT(coach_schedule.day, ' ', coach_schedule.start_time) <= '{$endTimeLimit->toDateTimeString()}'")
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        $times = null;

        $slots = collect();
        foreach ($events as $event) {

            $slot = $event->toSlot();
            $slots->push($slot);

        }

        return $slots;
    }


    public function obtainAvailabilityforBookSession(Filter $filter): \Illuminate\Database\Eloquent\Collection
    {
        return CoachSchedule::query()
            ->with($this->bookSessionRelations())
            ->where('blocked_ses', 0)
            //->whereNull('session_id')
            ->whereIn('coach_id', $filter->coachesIds())
            ->whereRaw("CONCAT(coach_schedule.day, ' ', coach_schedule.start_time) >= '".$filter->dateSlot()->start()->toDateTimeString()."'")
            ->whereRaw("CONCAT(coach_schedule.day, ' ', coach_schedule.end_time) <= '{$filter->dateSlot()->end()->toDateTimeString()}'")
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();
    }

    private function relations(): array
    {
        return [
            'coach',
        ];
    }

    private function calendarRelations(): array
    {
        return [
            'coach',
            'session',
            'session.course',
            'session.course.conversationPackage',
            'session.course.conversationPackage.sessionType',
            'session.course.university',
            'session.enrollmentSession',
        ];
    }

    private function bookSessionRelations():array{
        return [
            'coach',
            'coach.coachInfo',
            'coach.hobby',
            'session',
            'session.course',
            'session.enrollmentSession',
        ];
    }
}
