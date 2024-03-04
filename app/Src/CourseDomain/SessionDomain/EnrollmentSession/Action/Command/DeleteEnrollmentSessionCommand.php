<?php

namespace App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action\Command;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Exception\HourLimitExceeded;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionIsPast;

class DeleteEnrollmentSessionCommand
{
    public function handle(EnrollmentSession $enrollmentSession, bool $checkCanDelete = true): EnrollmentSession
    {

        if ($checkCanDelete){

            $this->checkSessionNotIsPast($enrollmentSession);

            $this->checkCanDelete($enrollmentSession);
        }

        $enrollmentSession->coachReview()->delete();

        $enrollmentSession->feedback()->delete();

        $enrollmentSessionIsRecoveredFromOther = $enrollmentSession->recovered AND !$enrollmentSession->isSame($enrollmentSession->recovered);
        if ($enrollmentSessionIsRecoveredFromOther) {
            //si está recuperando una, también la eliminamos ya que es más pasada todavía.
            $this->handle($enrollmentSession->recovered, false);
        }

        $enrollmentSession->delete();

        return $enrollmentSession;
    }

    private function checkSessionNotIsPast (EnrollmentSession $enrollmentSession){

        $scheduleSession = $enrollmentSession->scheduleSession();

        if ($scheduleSession->isPast()){
            throw new SessionIsPast();
        }
    }

    private function checkCanDelete (EnrollmentSession $enrollmentSession){

        $hourLimit = config('linguameeting.course.session.hours_limit.cancel');

        if ( ! $enrollmentSession->canChangeStatus($hourLimit)){
            throw new HourLimitExceeded();
        }
    }
}
