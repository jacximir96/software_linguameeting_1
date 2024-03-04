<?php

namespace App\Src\TimeDomain\TimeHour\Service;

use Illuminate\Support\Collection;

class BuilderTimes
{
    public function buildSlotsByInterval($minutesInterval): Collection
    {

        $slots = collect();
        $hour = 0;
        $minutes = 0;

        while ($hour < 24) {

            $slot = sprintf('%02d:%02d', $hour, $minutes);
            $slots->put($slot, $slot);
            $minutes += $minutesInterval;

            if ($minutes >= 60) {
                $minutes = 0;
                $hour++;
            }
        }

        return $slots;
    }
}
