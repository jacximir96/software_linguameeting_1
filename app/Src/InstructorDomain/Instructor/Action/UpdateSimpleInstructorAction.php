<?php

namespace App\Src\InstructorDomain\Instructor\Action;

use App\Src\InstructorDomain\Instructor\Request\UpdateSimpleInstructorRequest;
use App\Src\UserDomain\User\Model\User;

class UpdateSimpleInstructorAction
{
    public function handle(UpdateSimpleInstructorRequest $request, User $instructor): User
    {
        $instructor->name = $request->name;
        $instructor->lastname = $request->lastname;
        $instructor->email = $request->email;
        $instructor->save();

        return $instructor;
    }
}
