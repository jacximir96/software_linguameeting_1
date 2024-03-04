<?php
namespace App\Src\StudentRole\BookSession\Action;

use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Action\Command\CreateEnrollmentSessionCommand;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\CourseDomain\SessionDomain\Session\Model\Session;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;


//create un enrollment session en una session ya existente
class ScheduleSessionAction
{
    //construct
    private CreateEnrollmentSessionCommand $createEnrollmentSessionCommand;

    public function __construct(CreateEnrollmentSessionCommand $createEnrollmentSessionCommand,) {
        $this->createEnrollmentSessionCommand = $createEnrollmentSessionCommand;
    }

    public function handle(Session $session, Enrollment $enrollment, SessionOrder $sessionOrder): EnrollmentSession
    {

        return $this->createEnrollmentSessionCommand->handle($session, $enrollment, $sessionOrder);
    }

}
