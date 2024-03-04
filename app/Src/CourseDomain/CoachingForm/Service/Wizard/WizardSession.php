<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard;

use App\Src\CourseDomain\CoachingForm\Exception\WizardSessionNotExists;

class WizardSession
{
    public function get(): array
    {
        if (! session()->has($this->mainKeyInSession())) {
            throw new WizardSessionNotExists();
        }

        return session($this->mainKeyInSession());
    }

    public function reset()
    {
        session()->forget($this->mainKeyInSession());
    }

    public function saveInSession(array $data)
    {
        session()->put($this->mainKeyInSession(), $data);
    }

    private function mainKeyInSession(): string
    {
        return 'coaching-form';
    }
}
