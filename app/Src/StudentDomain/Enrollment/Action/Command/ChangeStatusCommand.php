<?php
namespace App\Src\StudentDomain\Enrollment\Action\Command;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action\CancelEnrollmentSessionAction;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\EnrollmentStatus\Model\EnrollmentStatus;
use Carbon\Carbon;


class ChangeStatusCommand
{

    private CancelEnrollmentSessionAction $cancelEnrollmentSessionAction;

    public function __construct (CancelEnrollmentSessionAction $cancelEnrollmentSessionAction){

        $this->cancelEnrollmentSessionAction = $cancelEnrollmentSessionAction;
    }

    public function handle(Enrollment $enrollment, EnrollmentStatus $status):Enrollment{

        $this->deleteFutureSessions($enrollment);

        //change status
        $enrollment->status_id = $status->id;
        $enrollment->status_at = Carbon::now();
        $enrollment->save();

        return $enrollment;
    }

    private function deleteFutureSessions (Enrollment $enrollment){

        foreach ($enrollment->enrollmentSession as $enrollmentSession){

            if ($enrollmentSession->scheduleSession()->isFuture()){
                $this->cancelEnrollmentSessionAction->handle($enrollmentSession);
            }
        }
    }
}
