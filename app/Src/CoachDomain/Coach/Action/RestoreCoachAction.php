<?php

namespace App\Src\CoachDomain\Coach\Action;

use App\Src\UserDomain\User\Model\User;

class RestoreCoachAction
{
    public function handle(User $coach): User
    {

        $coach->restore();

        return $coach;
    }
}
