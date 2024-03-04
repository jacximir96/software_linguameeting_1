<?php

namespace App\Src\UserDomain\ProfileImage\Repository;

use App\Src\UserDomain\ProfileImage\Model\ProfileImage;
use App\Src\UserDomain\User\Model\User;

class ProfileImageRepository
{
    public function obtainFromUser(User $user)
    {

        return ProfileImage::where('user_id', $user->id)->first();
    }
}
