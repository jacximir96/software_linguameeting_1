<?php
namespace App\Src\StudentDomain\Enrollment\Action;

use App\Src\StudentDomain\Enrollment\Action\Command\ChangeStatusCommand;
use App\Src\StudentDomain\Enrollment\Exception\EnrollmentHasFutureSession;
use App\Src\StudentDomain\Enrollment\Exception\EnrollmentIsNotActive;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\EnrollmentStatus\Service\EnrollmentStatusBuilder;


class RefundAction
{
    //construct
    private ChangeStatusCommand $changeStatusCommand;

    //status
    private Enrollment $enrollment;


    public function __construct (ChangeStatusCommand $changeStatusCommand){
        $this->changeStatusCommand = $changeStatusCommand;
    }

    public function handle(Enrollment $enrollment):Enrollment{

        $this->initialize($enrollment);

        $this->checkEnrollmentIsActive();

        $this->checkDoesntFutureSession();

        $this->changeStatus();

        return $this->enrollment;
    }

    private function initialize (Enrollment $enrollment){
        $this->enrollment = $enrollment;
    }

    private function checkEnrollmentIsActive (){

        if ( ! $this->enrollment->isActive()){
            throw new EnrollmentIsNotActive();
        }
    }

    private function checkDoesntFutureSession (){

        foreach ($this->enrollment->enrollmentSession as $enrollmentSession){

            if ($enrollmentSession->scheduleSession()->isFuture()){
                throw new EnrollmentHasFutureSession;
            }
        }
    }

    private function changeStatus (){

        $refundedStatus = EnrollmentStatusBuilder::buildRefunded();

        $this->changeStatusCommand->handle($this->enrollment, $refundedStatus);
    }
}
