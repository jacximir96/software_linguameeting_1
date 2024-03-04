<?php

namespace App\Src\StudentRole\BookSession\Service\Availability;

use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CoachFreeSlots
{
    private User $coach;

    private Collection $freeSlots;

    public function __construct(User $coach)
    {

        $this->coach = $coach;
        $this->freeSlots = collect();
    }

    public function coach(): User
    {
        return $this->coach;
    }

    public function freeSlots(): Collection
    {
        return $this->freeSlots;
    }

    public function addFreeSlot(FreeSlot $freeSlot)
    {
        $this->freeSlots->push($freeSlot);
    }

    public function hasFreeSlots ():bool{
        return $this->freeSlots->count();
    }

    public function date (Timezone $timezone):Carbon{
        return $this->freeSlots->first()->date($timezone);
    }

    public function startTime ():Carbon{
        return $this->freeSlots->first()->startTime();
    }
}
