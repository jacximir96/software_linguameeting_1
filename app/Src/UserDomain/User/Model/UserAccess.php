<?php

namespace App\Src\UserDomain\User\Model;

use App\Src\Localization\TimeZone\Model\TimeZone;

interface UserAccess
{
    public function isRegistered(): TimeZone;

    public function isPublic(): string;
}
