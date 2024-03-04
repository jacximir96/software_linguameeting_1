<?php

namespace App\Src\ExperienceDomain\Experience\Action;

use App\Src\ExperienceDomain\Experience\Model\Experience;

class DeleteExperienceAction
{
    public function handle(Experience $experience)
    {
        $experience->comment()->delete();

        $experience->donation()->delete();

        $experience->file()->delete();

        $experience->user()->delete();

        $experience->userPublic()->delete();

        $experience->delete();
    }
}
