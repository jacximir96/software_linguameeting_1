<?php

namespace App\Src\ExperienceDomain\ExperienceRegisterPublic\Repository;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceRegisterPublic\Model\ExperienceRegisterPublic;
use App\Src\UserDomain\UserPublic\Model\User;

class ExperienceRegisterPublicRepository
{
    public function checkUserInExperience(Experience $experience, User $user)
    {

        return ExperienceRegisterPublic::query()
            ->where('experience_id', $experience->id)
            ->where('user_id', $user->id)
            ->exists();

    }

    public function obtainByExperience(Experience $experience)
    {

        return ExperienceRegisterPublic::query()
            ->select('experience_register_public.*')
            ->with('user')
            ->join('user_public', 'experience_register_public.user_id', '=', 'user_public.id')
            ->where('experience_id', $experience->id)
            ->orderBy('user_public.lastname', 'asc')
            ->orderBy('user_public.name', 'asc')
            ->paginate(config('linguameeting.items_per_page'));
    }
}
