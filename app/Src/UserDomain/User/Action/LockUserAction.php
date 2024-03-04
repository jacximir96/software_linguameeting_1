<?php

namespace App\Src\UserDomain\User\Action;

use App\Src\UserDomain\User\Model\User;

class LockUserAction
{
    public function handle(User $user): User
    {

        $user->locked = ! $user->locked;
        $user->save();

        return $user;

    }
}
