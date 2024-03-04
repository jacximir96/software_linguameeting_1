<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Action\Command;

use App\Src\CourseDomain\SessionDomain\Session\Model\Session;

class DeleteSessionCommand
{
    public function handle(Session $session)
    {

        $session->zoomRecording()->delete();

        foreach ($session->coachSchedule as $coachSchedule){
            $coachSchedule->session_id = null;
            $coachSchedule->save();
        }

        foreach ($session->enrollmentSession as $enrollmentSession){
            $enrollmentSession->delete();
        }


        $session->delete();

    }
}
