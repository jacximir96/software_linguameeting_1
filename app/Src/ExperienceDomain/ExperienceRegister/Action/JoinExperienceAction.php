<?php

namespace App\Src\ExperienceDomain\ExperienceRegister\Action;

use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class JoinExperienceAction
{
    public function handle(ExperienceRegister $experienceRegister, User $user): ExperienceRegister
    {

        $now = Carbon::now();

        $experienceRegister->joined_at = $now;
        $experienceRegister->save();

        $experienceRegister->attendance = true;

        return $experienceRegister;
    }
}
