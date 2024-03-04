<?php

namespace App\Src\StudentDomain\Student\Action;

use App\Src\UserDomain\User\Model\User;

class RestoreStudentAction
{
    public function handle(User $student): User
    {

        $student->restore();

        return $student;
    }
}
