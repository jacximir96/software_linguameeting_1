<?php

namespace App\Src\ExperienceDomain\ExperienceComment\Repository;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\ExperienceComment\Model\ExperienceComment;

class ExperienceCommentRepository
{
    public function obtainByExperience(Experience $experience)
    {

        return ExperienceComment::query()
            ->with('user')
            ->where('experience_id', $experience->id)
            ->orderBy('id', 'desc')
            ->paginate(config('linguameeting.items_per_page'));

    }
}
