<?php

namespace App\Src\CoachDomain\CoachSchedule\Action\Command;

use App\Src\CoachDomain\CoachSchedule\Model\CoachSchedule;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;

//asigna a CoachSchedule's una session
class AssignSessionToIdsCommand
{
    public function handle(array $coachScheduleIds, Session $session)
    {

        $coachSchedules = CoachSchedule::whereIn('id', $coachScheduleIds)->get();

        foreach ($coachSchedules as $coachSchedule) {
            $coachSchedule->session_id = $session->id;
            $coachSchedule->save();
        }
    }
}
