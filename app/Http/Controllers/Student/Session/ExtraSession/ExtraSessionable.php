<?php


namespace App\Http\Controllers\Student\Session\ExtraSession;


use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Exception\SessionOrderIsInvalid;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;

trait ExtraSessionable
{

    public function checkSessionOrderIsValid (Enrollment $enrollment, int $sessionOrder){

        $enrollmentSessionRepository = app(EnrollmentSessionRepository::class);

        $nextSessionOrder = $enrollmentSessionRepository->nextSessionOrder ($enrollment);

        if ($nextSessionOrder->get() != $sessionOrder){
            throw new SessionOrderIsInvalid();
        }
    }
}
