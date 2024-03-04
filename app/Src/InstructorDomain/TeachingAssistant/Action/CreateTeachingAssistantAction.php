<?php

namespace App\Src\InstructorDomain\TeachingAssistant\Action;

use App\Src\InstructorDomain\Instructor\Action\CreateInstructorCommand;
use App\Src\InstructorDomain\Instructor\Request\SectionTeachingAssistantRequest;
use App\Src\Localization\Language\Model\Language;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;

class CreateTeachingAssistantAction
{
    private CreateInstructorCommand $createInstructorCommand;

    public function __construct(CreateInstructorCommand $createInstructorCommand)
    {
        $this->createInstructorCommand = $createInstructorCommand;
    }

    public function handle(SectionTeachingAssistantRequest $request, University $university, Language $language): User
    {
        $rol = collect(config('linguameeting.user.roles.ids.teaching_assistant'));

        return $this->createInstructorCommand->handle($request, $university, $language, $rol);
    }
}
