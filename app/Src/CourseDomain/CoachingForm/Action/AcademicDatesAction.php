<?php

namespace App\Src\CourseDomain\CoachingForm\Action;

use App\Src\CourseDomain\CoachingForm\Request\AcademicDatesRequest;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\WizardManager;

class AcademicDatesAction
{
    private WizardManager $wizardManager;

    public function __construct(WizardManager $wizardManager)
    {
        $this->wizardManager = $wizardManager;
    }

    public function handle(AcademicDatesRequest $request)
    {
        $this->wizardManager->saveRequestInSession($request);
    }
}
