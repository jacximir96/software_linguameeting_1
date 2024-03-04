<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard;

class WizardNewCourse extends Wizard
{
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function addUniversityId(int $universityId)
    {
        $this->data['university_id'] = $universityId;
    }

    public function addServiceWithExperience(): bool
    {
        return $this->data['service_with_experiences'] = true;
    }

    public function isNew(): bool
    {
        return true;
    }
}
