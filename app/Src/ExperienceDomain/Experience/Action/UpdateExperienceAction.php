<?php

namespace App\Src\ExperienceDomain\Experience\Action;

use App\Src\ExperienceDomain\Experience\Model\Experience;
use App\Src\ExperienceDomain\Experience\Request\ExperienceRequest;

class UpdateExperienceAction
{
    private ProcessExperienceRequest $processExperienceRequest;

    public function __construct(ProcessExperienceRequest $processExperienceRequest)
    {

        $this->processExperienceRequest = $processExperienceRequest;
    }

    public function handle(ExperienceRequest $request, Experience $experience): Experience
    {

        return $this->processExperienceRequest->handle($request, $experience);

    }
}
