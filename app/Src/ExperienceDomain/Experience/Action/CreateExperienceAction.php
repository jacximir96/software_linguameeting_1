<?php

namespace App\Src\ExperienceDomain\Experience\Action;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Request\ExperienceRequest;

class CreateExperienceAction
{
    private ProcessExperienceRequest $processExperienceRequest;

    public function __construct(ProcessExperienceRequest $processExperienceRequest)
    {
        $this->processExperienceRequest = $processExperienceRequest;
    }

    public function handle(ExperienceRequest $request): Experience
    {
        $experience = new Experience();

        $experience = $this->processExperienceRequest->handle($request, $experience);

        return $experience;
    }
}
