<?php

namespace App\Src\UserDomain\User\Action;

use App\Src\CoachDomain\Coach\Action\ProcessRequest;
use App\Src\UserDomain\User\Model\User;
use App\Src\UserDomain\User\Request\UpdateProfileRequest;

class UpdateProfileAction
{
    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {

        $this->processRequest = $processRequest;
    }

    public function handle(UpdateProfileRequest $request, User $user): User
    {
        return $this->processRequest->updatePersonalData($request, $user);
    }
}
