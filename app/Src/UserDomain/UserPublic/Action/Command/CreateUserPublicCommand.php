<?php

namespace App\Src\UserDomain\UserPublic\Action\Command;

use App\Src\UserDomain\UserPublic\Model\User;

class CreateUserPublicCommand
{
    public function handle(UserDto $dto): User
    {

        $user = new User();

        $user->name = $dto->getFirstName();
        $user->lastname = $dto->getLastName();
        $user->email = $dto->getEmail();
        $user->school = $dto->getSchool();

        $user->save();

        $user->setTimezone($dto->getTimeZone());

        return $user;
    }
}
