<?php
namespace App\Src\ExperienceDomain\Experience\Presenter;

use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;


class StudentItem
{

    private User $student;

    private Enrollment $enrollment;

    public function __construct (User $student, Enrollment $enrollment){
        $this->student = $student;
        $this->enrollment = $enrollment;
    }

    public function student(): User
    {
        return $this->student;
    }

    public function enrollment():Enrollment{
        return $this->enrollment;
    }
}
