<?php

namespace App\Src\UserDomain\User\Action;

use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Facades\RateLimiter;

class RemoveLockAction
{
    public function handle(User $user): User
    {

        RateLimiter::clear($user->throttleKey());

        $user->locked = false;
        $user->save();

        return $user;
    }
}
