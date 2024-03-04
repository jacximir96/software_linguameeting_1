<?php

namespace App\Src\InstructorDomain\Instructor\Action;

use App\Src\InstructorDomain\Instructor\Request\CourseCoordinatorRequest;
use App\Src\Localization\Language\Model\Language;
use App\Src\UniversityDomain\University\Model\University;
use App\Src\UserDomain\User\Model\User;

class CreateCourseCoordinatorAction
{
    private CreateInstructorCommand $createInstructorCommand;

    public function __construct(CreateInstructorCommand $createInstructorCommand)
    {
        $this->createInstructorCommand = $createInstructorCommand;
    }

    public function handle(CourseCoordinatorRequest $request, University $university, Language $language): User
    {
        $rol = collect(config('linguameeting.user.roles.ids.course_coordinator'));

        return $this->createInstructorCommand->handle($request, $university, $language, $rol);
    }
}
