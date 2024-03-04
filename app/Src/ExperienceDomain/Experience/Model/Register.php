<?php

namespace App\Src\ExperienceDomain\Experience\Model;

use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Model\ExperienceRegisterPublic;
use App\Src\Localization\TimeZone\Model\TimeZone;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

trait Register
{
    public function register()
    {
        return $this->hasMany(ExperienceRegister::class);
    }

    public function registerPublic()
    {
        return $this->hasMany(ExperienceRegisterPublic::class);
    }

    public function userIsRegistered(User $user): bool
    {

        foreach ($this->register as $register) {
            if ($register->isUser($user)) {
                return true;
            }
        }

        return false;
    }

    public function userAttendance(User $user): bool
    {
        foreach ($this->register as $register) {
            if ($register->isUser($user)) {
                if ($register->isAttendance()) {
                    return true;
                }
            }
        }

        return false;
    }

    public function studentCanBeJoin(): bool
    {

        $now = Carbon::now();

        $startTime = $this->startTime();
        $endTime = $this->endTime();

        return $now->greaterThanOrEqualTo($startTime) and $now->lessThan($endTime);

    }
}
