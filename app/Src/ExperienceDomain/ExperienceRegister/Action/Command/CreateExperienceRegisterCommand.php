<?php

namespace App\Src\ExperienceDomain\ExperienceRegister\Action\Command;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegister\Model\ExperienceRegister;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class CreateExperienceRegisterCommand
{
    public function handle(Experience $experience, User $user): ExperienceRegister
    {

        $register = new ExperienceRegister();
        $register->experience_id = $experience->id;
        $register->user_id = $user->id;
        $register->registered_at = Carbon::now();

        $register->save();

        return $register;
    }
}
