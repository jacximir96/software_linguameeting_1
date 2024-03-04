<?php

namespace App\Src\StudentRole\BookSession\Service\Availability;

use App\Src\Localization\TimeZone\Model\TimeZone;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class Availability
{
    private Carbon $date;

    private Collection $availabilitiesTimeHours;

    public function __construct(Carbon $date)
    {

        $this->date = $date;
        $this->availabilitiesTimeHours = collect();
    }

    public function date(): Carbon
    {
        return $this->date;
    }

    public function hours(): Collection
    {
        return $this->availabilitiesTimeHours;
    }

    public function add(AvailabilitiesTimeHour $availabilityTimeHour)
    {
        $this->availabilitiesTimeHours->put($availabilityTimeHour->timeHour()->id, $availabilityTimeHour);
    }

    public function first(): AvailabilitiesTimeHour
    {
        return $this->availabilitiesTimeHours->first();
    }

    public function addFreeSlot(FreeSlot $freeSlot, TimeZone $timeZone)
    {

        $first = $freeSlot->coachSchedules()->first();
        $startDateWithTimezone = $first->startWithOtherTimezone($timeZone);

        foreach ($this->availabilitiesTimeHours as $availabilityTimeHour) {

            if ($availabilityTimeHour->hourBelongsToHere($startDateWithTimezone)) {
                $availabilityTimeHour->addFreeSlot($freeSlot);

                return;
            }
        }
    }

    public function obtainCoaches ():Collection{

        $coaches = collect();

        foreach ($this->availabilitiesTimeHours as $availabilityTimeHour){

            foreach ($availabilityTimeHour->coachFreeSlots() as $coachFreeSlot){
                $coach = $coachFreeSlot->coach();

                if ( ! $coaches->has($coach->id)){
                    $coaches->put($coach->id, $coach);
                }
            }
        }

        return $coaches;
    }
}
