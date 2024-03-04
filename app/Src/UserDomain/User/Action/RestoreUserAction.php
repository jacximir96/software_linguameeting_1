<?php

namespace App\Src\UserDomain\User\Action;

use App\Src\UserDomain\User\Model\User;

class RestoreUserAction
{
    public function handle(User $user)
    {
        $user->restore();
    }
}
