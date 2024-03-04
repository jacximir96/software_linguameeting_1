<?php

namespace App\Src\UniversityDomain\Instructor\Action;

use App\Src\UniversityDomain\Instructor\Model\UniversityInstructor;
use App\Src\UniversityDomain\Instructor\Request\AssignUniversityRequest;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;

class AssignUniversityAction
{
    private AssignUniversityCommand $assignUniversityInstructorCommand;

    public function __construct(AssignUniversityCommand $assignUniversityInstructorCommand)
    {
        $this->assignUniversityInstructorCommand = $assignUniversityInstructorCommand;
    }

    public function handle(AssignUniversityRequest $request, User $instructor): UniversityInstructor
    {
        $university = University::find($request->university_id);

        return $this->assignUniversityInstructorCommand->handle($university, $instructor);
    }
}
