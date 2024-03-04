<?php

namespace App\Src\CourseDomain\CoachingForm\Service\Wizard;

use App\Src\CourseDomain\CoachingForm\Exception\WizardFieldNotExists;

abstract class Wizard
{
    protected array $data;

    abstract public function isNew(): bool;

    public function addData(array $data)
    {
        $this->data = array_merge($this->data, $data);
    }

    public function addType(string $type)
    {
        $this->data['type'] = $type;
    }

    public function complimentaryMakeup(): bool
    {
        return $this->valueBoolean('complimentary_makeup');
    }

    public function conversationPackageTypeId(): int
    {
        return $this->data['session_type_id'];
    }

    public function discount(): float
    {
        return (float) $this->data['discount'];
    }

    public function durationSessions(): int
    {
        if (! $this->hasField('duration_session')) {
            throw new WizardFieldNotExists();
        }

        return (int) $this->getField('duration_session');
    }

    public function empty(string $field): bool
    {
        return empty($this->getField($field));
    }

    public function endDate(): string
    {
        return $this->data['end_date'];
    }

    public function get(): array
    {
        return $this->data;
    }

    public function getField(string $field)
    {
        if (! isset($this->data[$field])) {
            throw new \Exception(sprintf('Field %s not exists', $field));
        }

        return $this->data[$field];
    }

    public function guideId(): int
    {
        return $this->data['guide_id'];
    }

    public function hasDiscount(): bool
    {
        if (! $this->hasField('discount')) {
            return false;
        }

        return is_numeric($this->getField('discount'));
    }

    public function hasEndDate(): bool
    {
        if (! $this->hasField('end_date')) {
            return false;
        }

        return ! $this->empty('end_date');
    }

    public function hasField(string $field): bool
    {
        return isset($this->data[$field]);
    }

    public function hasGuideId(): bool
    {
        if (! $this->hasField('guide_id')) {
            return false;
        }

        return ! $this->empty('guide_id');
    }

    public function hasSessionTypeId(): bool
    {
        return $this->hasField('student_class');
    }

    public function hasStartDate(): bool
    {
        if (! $this->hasField('start_date')) {
            return false;
        }

        return ! $this->empty('start_date');
    }

    public function hasStudentsSession(): bool
    {
        if (! $this->hasField('student_class')) {
            return false;
        }

        return is_numeric($this->getField('student_class'));
    }

    public function holidays(): array
    {
        if (! $this->hasField('holidays')) {
            return [];
        }

        if (! is_array($this->data['holidays'])) {
            return [];
        }

        return $this->data['holidays'];
    }

    public function isFree(): bool
    {
        return $this->valueBoolean('is_free');
    }

    public function isLingro(): bool
    {
        return $this->valueBoolean('user_lingro');
    }

    public function numberMakeups(): int
    {
        if (! $this->hasField('number_makeups')) {
            return 0;
        }

        return (int) $this->getField('number_makeups');
    }

    public function name(): string
    {
        if (! $this->hasField('name')) {
            throw new WizardFieldNotExists();
        }

        return $this->getField('name');
    }

    public function numSessions(): int
    {
        return (int) $this->getField('number_session');
    }

    public function languageId(): int
    {
        return $this->data['language_id'];
    }

    public function semesterId(): int
    {
        return $this->getField('semester_id');
    }

    public function sessionTypeId(): int
    {
        return $this->getField('session_type_id');
    }

    public function startDate(): string
    {
        return $this->data['start_date'];
    }

    public function studentsClass(): int
    {
        if (! $this->hasField('student_class')) {
            throw new WizardFieldNotExists();
        }

        return (int) $this->data['student_class'];
    }

    public function studentsSession(): int
    {
        return $this->studentsClass();
    }

    public function universityId(): int
    {
        return $this->data['university_id'];
    }

    public function valueBoolean(string $field): bool
    {
        if (! $this->hasField($field)) {
            return false;
        }

        $value = $this->getField($field);

        if (! is_numeric($value)) {
            return false;
        }

        return (bool) $value;
    }

    public function withExperience(): bool
    {
        if (! $this->hasField('experience')) {
            return false;
        }

        return (bool) $this->getField('experience');
    }

    public function isServiceWithExperiences(): bool
    {

        if (! $this->hasField('service_with_experiences')) {
            return false;
        }

        return (bool) $this->getField('service_with_experiences');
    }

    public function year(): int
    {
        if (! $this->hasField('year')) {
            throw new WizardFieldNotExists();
        }

        return (int) $this->getField('year');
    }
}
