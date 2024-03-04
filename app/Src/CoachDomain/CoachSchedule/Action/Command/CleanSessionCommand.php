<?php

namespace App\Src\CoachDomain\CoachSchedule\Action\Command;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;

class CleanSessionCommand
{
    public function handle(CoachSchedule $coachSchedule): CoachSchedule
    {

        $coachSchedule->session_id = null;

        $coachSchedule->save();

        return $coachSchedule;
    }
}
