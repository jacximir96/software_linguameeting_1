<?php

namespace App\Src\CourseDomain\CoachingForm\Action;

use App\Src\CourseDomain\CoachingForm\Request\StartRequest;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\SessionWizardFactory;
use App\Src\CourseDomain\CoachingForm\Service\Wizard\WizardSession;

class WizardCreateAction
{
    private SessionWizardFactory $sessionWizardFactory;

    private WizardSession $wizardSession;

    public function __construct(SessionWizardFactory $sessionWizardFactory, WizardSession $wizardSession)
    {
        $this->sessionWizardFactory = $sessionWizardFactory;
        $this->wizardSession = $wizardSession;
    }

    public function handle(StartRequest $request, bool $withExperiences)
    {
        $this->resetSession();

        $this->saveWizardInSession($request, $withExperiences);
    }

    private function resetSession()
    {
        $this->wizardSession->reset();
    }

    private function saveWizardInSession(StartRequest $request, bool $withExperiences)
    {
        $wizard = $this->sessionWizardFactory->buildWizardForCreate();
        $wizard->addType('new');
        $wizard->addUniversityId($request->university_id);

        if ($withExperiences) {
            $wizard->addServiceWithExperience();
        }

        $this->wizardSession->saveInSession($wizard->get());
    }
}
