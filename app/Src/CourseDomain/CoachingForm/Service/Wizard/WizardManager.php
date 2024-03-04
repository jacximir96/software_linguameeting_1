<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard;

use Illuminate\Foundation\Http\FormRequest;

class WizardManager
{
    private SessionWizardFactory $sessionWizardFactory;

    private WizardSession $wizardSession;

    public function __construct(SessionWizardFactory $sessionWizardFactory, WizardSession $wizardSession)
    {
        $this->sessionWizardFactory = $sessionWizardFactory;
        $this->wizardSession = $wizardSession;
    }

    public function saveRequestInSession(FormRequest $request): Wizard
    {
        $wizard = $this->sessionWizardFactory->buildFromSession();

        $wizard->addData($request->except('_token'));

        $this->wizardSession->saveInSession($wizard->get());

        return $wizard;
    }
}
