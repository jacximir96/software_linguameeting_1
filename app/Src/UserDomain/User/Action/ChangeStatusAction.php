<?php

namespace App\Src\UserDomain\User\Action;

use App\Src\UserDomain\User\Model\User;

class ChangeStatusAction
{
    public function handle(User $user): User
    {

        $user->active = ! $user->active;
        $user->save();

        return $user;
    }
}
