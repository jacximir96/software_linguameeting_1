<?php

namespace App\Src\InstructorDomain\Instructor\Action;

use App\Src\InstructorDomain\Instructor\Request\CreateSimpleRequest;
use App\Src\Localization\Language\Model\Language;
use App\Src\UniversityDomain\Instructor\Action\AssignUniversityCommand;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;

class CreateInstructorSimpleAction
{
    private CreateInstructorCommand $createInstructorCommand;

    private AssignUniversityCommand $assignUniversityCommand;

    public function __construct(CreateInstructorCommand $createInstructorCommand, AssignUniversityCommand $assignUniversityCommand)
    {
        $this->createInstructorCommand = $createInstructorCommand;
        $this->assignUniversityCommand = $assignUniversityCommand;
    }

    public function handle(CreateSimpleRequest $request, University $university, Language $language): User
    {

        $rol = collect($request->role_id);

        $instructor = $this->createInstructorCommand->handle($request, $university, $language, $rol);

        $this->assignUniversityCommand->handle($university, $instructor);

        return $instructor;

    }
}
