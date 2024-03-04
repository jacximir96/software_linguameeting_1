<?php
namespace App\Src\StudentDomain\Student\Action;

use App\Src\StudentDomain\Enrollment\Action\DeleteEnrollmentAction;
use App\Src\UserDomain\User\Model\User;


class DeleteStudentAction
{

    private DeleteEnrollmentAction $deleteEnrollmentAction;

    public function __construct (DeleteEnrollmentAction $deleteEnrollmentAction){

        $this->deleteEnrollmentAction = $deleteEnrollmentAction;
    }

    public function handle(User $student):User{

        $this->deleteEnrollment($student);

        $student->delete();

        return $student;
    }

    private function deleteEnrollment(User $user){

        foreach ($user->enrollment as $enrollment){
            $this->deleteEnrollmentAction->handle($enrollment);
        }

    }

}
