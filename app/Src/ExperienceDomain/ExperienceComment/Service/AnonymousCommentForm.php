<?php

namespace App\Src\ExperienceDomain\ExperienceComment\Service;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\Shared\Service\BaseSearchForm;

class AnonymousCommentForm extends BaseSearchForm
{
    public function config(Experience $experience)
    {
        $this->action = route('post.public.experience.rate.create', $experience->hashId());

        $this->model = [];
    }
}
