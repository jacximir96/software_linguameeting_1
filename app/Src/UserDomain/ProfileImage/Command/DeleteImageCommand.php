<?php

namespace App\Src\UserDomain\ProfileImage\Command;

use App\Src\UserDomain\ProfileImage\Model\ProfileImage;

class DeleteImageCommand
{
    public function handle(ProfileImage $profileImage): ProfileImage
    {

        $profileImage->delete();

        return $profileImage;
    }
}
