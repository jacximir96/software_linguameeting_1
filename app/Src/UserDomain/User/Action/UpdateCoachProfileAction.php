<?php

namespace App\Src\UserDomain\User\Action;

use App\Src\CoachDomain\Coach\Action\UpdateCoachAction;
use App\Src\UserDomain\User\Model\User;
use App\Src\UserDomain\User\Request\CoachProfileRequest;

class UpdateCoachProfileAction
{
    private UpdateCoachAction $updateCoachAction;

    public function __construct(UpdateCoachAction $updateCoachAction)
    {

        $this->updateCoachAction = $updateCoachAction;
    }

    public function handle(CoachProfileRequest $request, User $coach): User
    {
        return $this->updateCoachAction->handle($request, $coach);
    }
}
