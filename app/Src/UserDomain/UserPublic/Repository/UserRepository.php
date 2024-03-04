<?php

namespace App\Src\UserDomain\UserPublic\Repository;

use App\Src\UserDomain\UserPublic\Model\User;

class UserRepository
{
    public function findByEmail(string $email)
    {

        return User::where('email', $email)->first();
    }
}
