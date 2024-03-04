<?php

namespace App\Src\InstructorDomain\Instructor\Action;

use App\Src\InstructorDomain\Instructor\Request\UpdateFullInstructorRequest;
use App\Src\UserDomain\User\Model\User;

class UpdateInstructorAction
{
    private InstructorProcessRequest $processRequest;

    public function __construct(InstructorProcessRequest $processRequest)
    {
        $this->processRequest = $processRequest;
    }

    public function handle(UpdateFullInstructorRequest $request, User $instructor): User
    {
        $this->processRequest->handle($request, $instructor);

        $instructor->save();

        $instructor->language()->sync($request->language);

        $instructor->syncRoles($request->role_id);

        return $instructor;
    }
}
