<?php
namespace App\Src\StudentRole\BookSession\Service\Availability;

use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\StudentRole\BookSession\Service\Availability\Algorithm\CoachesScored;
use App\Src\TimeDomain\TimeHour\Model\TimeHour;
use Carbon\Carbon;
use Illuminate\Support\Collection;


/**
 * Esta clase contiene un TimeHour (model): id, time_id, name, start, end y todas las disponibilidades de los coaches en ese rango de hora.
 */
class AvailabilitiesTimeHour
{
    private TimeHour $timeHour;

    private Collection $coachFreeSlots;

    private CoachesScored $coachesScored;

    public function __construct(TimeHour $timeHour)
    {
        $this->timeHour = $timeHour;
        $this->coachFreeSlots = collect();

        $this->coachesScored = app(CoachesScored::class);
    }

    public function assignCoachesScored (CoachesScored $coachesScored){
        $this->coachesScored = $coachesScored;
    }

    public function timeHour(): TimeHour
    {
        return $this->timeHour;
    }

    public function coachFreeSlots(): Collection
    {
        return $this->coachFreeSlots;
    }

    public function coachFreeSlotsSortedTo(): Collection
    {

        if ($this->coachesScored->hasSorted()){

            $final = collect();

            foreach ($this->coachesScored->coachScores() as $coachScore){

                foreach ($this->coachFreeSlots as $coachFreeSlots){

                    if ($coachScore->coach()->id == $coachFreeSlots->coach()->id){
                        $final->push($coachFreeSlots);
                    }
                }
            }

            return $final;
        }

        return $this->coachFreeSlots->take(config('linguameeting.session.algorithm.num_coaches_returned'));
    }

    public function builStartDate(Carbon $date, TimeZone $timeZone): Carbon
    {
        return Carbon::parse($date->toDateString().' '.$this->timeHour->start, $timeZone->name);
    }

    public function builEndDate(Carbon $date, TimeZone $timeZone): Carbon
    {
        return Carbon::parse($date->toDateString().' '.$this->timeHour->end, $timeZone->name);
    }

    public function hourBelongsToHere(Carbon $moment): bool
    {
        return $this->timeHour->inRange($moment);
    }

    public function addFreeSlot(FreeSlot $freeSlot)
    {

        $first = $freeSlot->coachSchedules()->first();

        $coachId = $first->coach_id;

        if (! $this->coachFreeSlots->has($coachId)) {

            $coachFreeSlots = new CoachFreeSlots($first->coach);
            $this->coachFreeSlots->put($coachId, $coachFreeSlots);
        }

        $coachFreeSlots = $this->coachFreeSlots->get($coachId);
        $coachFreeSlots->addFreeSlot($freeSlot);
    }
}
