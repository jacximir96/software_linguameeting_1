<?php

namespace App\Src\UserDomain\User\Action;

use App\Src\UserDomain\User\Action\Command\ProcessCommonProfileCommand;
use App\Src\UserDomain\User\Model\User;
use App\Src\UserDomain\User\Request\UpdateProfileRequest;

class UpdateStudentProfileAction
{
    private ProcessCommonProfileCommand $processCommonProfileCommand;

    public function __construct(ProcessCommonProfileCommand $processCommonProfileCommand)
    {

        $this->processCommonProfileCommand = $processCommonProfileCommand;
    }

    public function handle(UpdateProfileRequest $request, User $student): User
    {
        return $this->processCommonProfileCommand->handle($request, $student);
    }
}
