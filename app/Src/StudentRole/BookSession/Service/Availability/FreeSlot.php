<?php

namespace App\Src\StudentRole\BookSession\Service\Availability;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FreeSlot
{
    private Collection $coachSchedules;

    public function __construct(Collection $coachSchedules)
    {

        $this->coachSchedules = $coachSchedules;
    }

    public function coachSchedules(): Collection
    {
        return $this->coachSchedules;
    }

    public function coachSchedulesIds(): array
    {
        return $this->coachSchedules->pluck('id')->toArray();
    }

    public function first(): CoachSchedule
    {
        return $this->coachSchedules->first();
    }

    public function hasDate ():bool{
        return $this->coachSchedules->count();
    }

    public function date ():Carbon{

        $coachSchedule = $this->first();

        return $coachSchedule->day;
    }

    public function startTime ():Carbon
    {

        $coachSchedule = $this->first();

        return Carbon::parse($coachSchedule->day->toDateString() . ' ' . $coachSchedule->start_time);
    }
}
