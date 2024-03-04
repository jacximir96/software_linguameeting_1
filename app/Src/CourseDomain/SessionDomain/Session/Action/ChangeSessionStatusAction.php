<?php

namespace App\Src\CourseDomain\SessionDomain\Session\Action;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\SessionStatus\Model\SessionStatus;
use Carbon\Carbon;

class ChangeSessionStatusAction
{
    public function handle(EnrollmentSession $enrollmentSession, SessionStatus $sessionStatus): EnrollmentSession
    {

        $enrollmentSession->session_status_id = $sessionStatus->id;
        $enrollmentSession->status_at = Carbon::now();
        $enrollmentSession->save();

        return $enrollmentSession;
    }
}
