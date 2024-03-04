<?php
namespace App\Src\StudentDomain\Makeup\Service;

//wrapper de la variable de sesión  isMakeup
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Model\EnrollmentSession;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;

class MakeupInfoSession
{

    private array $data;

    public function __construct (array $data){

        $this->data = $data;
    }

    public function isBookedSession ():bool{
        return $this->data['type'] == 'booked_session';
    }

    public function enrollmentSession ():EnrollmentSession{
        return EnrollmentSession::withTrashed()->find($this->data['recovered']['enrollment_session_id']);
    }

    public function enrollment ():Enrollment{

    }
}
