<?php

namespace App\Src\StudentDomain\Enrollment\Presenter;

use App\Src\Shared\Service\FieldFormBuilder;

class OptionsGroup
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $sessionStatusOptions = [];

    private array $puntualityOptions = [];

    private array $preparedClassOptions = [];

    private array $participationOptions = [];

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {

        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configOptions()
    {

        $this->configSessionStatusOptions();

        $this->configPuntualityOptions();

        $this->configPreparedClassOptions();

        $this->configParticipationOptions();
    }

    private function configSessionStatusOptions()
    {
        $this->sessionStatusOptions = $this->fieldFormBuilder->obtainSessionStatusOptions();
    }

    private function configPuntualityOptions()
    {
        $this->puntualityOptions = $this->fieldFormBuilder->obtainPuntualityTypeOptions('description');
    }

    private function configPreparedClassOptions()
    {
        $this->preparedClassOptions = $this->fieldFormBuilder->obtainPreparedClassOptions('description');
    }

    private function configParticipationOptions()
    {
        $this->participationOptions = $this->fieldFormBuilder->obtainParticipationTypeOptions('description');
    }
}
