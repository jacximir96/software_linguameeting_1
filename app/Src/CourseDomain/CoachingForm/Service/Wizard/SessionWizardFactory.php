<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard;

class SessionWizardFactory
{
    private WizardSession $wizardSession;

    public function __construct(WizardSession $wizardSession)
    {
        $this->wizardSession = $wizardSession;
    }

    public function buildWizardForCreate(): WizardNewCourse
    {
        return new WizardNewCourse();
    }

    public function buildFromSession(): Wizard
    {
        if ($this->isNew()) {
            return new WizardNewCourse($this->wizardSession->get());
        }
    }

    private function isNew(): bool
    {
        $sessionData = $this->wizardSession->get();

        return $sessionData['type'] == 'new';
    }
}
