<?php

namespace App\Src\InstructorDomain\Instructor\Action;

use App\Src\InstructorDomain\Instructor\Request\CreateFullInstructorRequest;
use App\Src\UserDomain\Password\Service\PasswordService;
use App\Src\UserDomain\User\Model\User;

class CreateInstructorAction
{
    private InstructorProcessRequest $processRequest;

    private PasswordService $password;

    public function __construct(InstructorProcessRequest $processRequest, PasswordService $password)
    {
        $this->processRequest = $processRequest;
        $this->password = $password;
    }

    public function handle(CreateFullInstructorRequest $request): User
    {
        $instructor = new User();
        $instructor->password = $this->password->generatePassword();

        $this->processRequest->handle($request, $instructor, $this->password);

        $instructor->save();

        $instructor->language()->sync($request->language);

        $instructor->assignRole($request->role_id);

        $instructor->university()->sync($request->university_id);

        return $instructor;
    }
}
