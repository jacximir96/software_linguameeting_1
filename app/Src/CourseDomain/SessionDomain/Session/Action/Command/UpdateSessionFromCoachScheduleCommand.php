<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Action\Command;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\ScheduleSession;
use App\Src\UserDomain\User\Model\User;

class UpdateSessionFromCoachScheduleCommand
{
    public function handle(Session $session, User $coach, ScheduleSession $scheduleSession): Session
    {

        $session->coach_id = $coach->id;
        $session->day = $scheduleSession->date();
        $session->start_time = $scheduleSession->timeSlot()->start()->get();
        $session->end_time = $scheduleSession->timeSlot()->end()->get();

        $session->save();

        return $session;
    }
}
