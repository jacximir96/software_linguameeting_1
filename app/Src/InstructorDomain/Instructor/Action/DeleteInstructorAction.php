<?php

namespace App\Src\InstructorDomain\Instructor\Action;

use App\Src\UserDomain\User\Model\User;

class DeleteInstructorAction
{
    public function handle(User $instructor)
    {
        $instructor->delete();
    }
}
