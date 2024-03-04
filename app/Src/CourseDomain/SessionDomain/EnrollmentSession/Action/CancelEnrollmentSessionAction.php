<?php
namespace App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action\Command\DeleteEnrollmentSessionCommand;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Action\Command\DeleteSessionCommand;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;


class CancelEnrollmentSessionAction
{
    //construct
    private DeleteEnrollmentSessionCommand $deleteEnrollmentSessionCommand;
    private DeleteSessionCommand $deleteSessionCommand;

    //status
    private EnrollmentSession $enrollmentSession;

    private Session $currentSession;


    public function __construct (DeleteEnrollmentSessionCommand $deleteEnrollmentSessionCommand, DeleteSessionCommand $deleteSessionCommand){

        $this->deleteEnrollmentSessionCommand = $deleteEnrollmentSessionCommand;
        $this->deleteSessionCommand = $deleteSessionCommand;
    }

    public function handle(EnrollmentSession $enrollmentSession, bool $checkCanDelete = true):EnrollmentSession{

        $this->initialize($enrollmentSession);

        $this->deleteEnrollmentSessionCommand->handle($enrollmentSession, $checkCanDelete);

        $this->currentSession->fresh();

        if ($this->currentSession->occupation()->isEmpty()){
            $this->deleteSessionCommand->handle($this->currentSession);
        }

        return $enrollmentSession;
    }

    private function initialize (EnrollmentSession $enrollmentSession){
        $this->enrollmentSession = $enrollmentSession;
        $this->currentSession = $enrollmentSession->session;
    }
}
