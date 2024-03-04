<?php

namespace App\Src\ExperienceDomain\ExperienceRegisterPublic\Action\Command;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Model\ExperienceRegisterPublic;
use App\Src\UserDomain\UserPublic\Model\User;
use Carbon\Carbon;

class CreateExperienceRegisterCommand
{
    public function handle(Experience $experience, User $user): ExperienceRegisterPublic
    {

        $register = new ExperienceRegisterPublic();
        $register->experience_id = $experience->id;
        $register->user_id = $user->id;
        $register->registered_at = Carbon::now();

        $register->save();

        return $register;
    }
}
