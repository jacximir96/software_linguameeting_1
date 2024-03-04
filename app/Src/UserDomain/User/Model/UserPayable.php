<?php

namespace App\Src\UserDomain\User\Model;

use App\Src\Localization\TimeZone\Model\TimeZone;

interface UserPayable
{
    public function userTimezone(): TimeZone;

    public function writeFullName(): string;
}
