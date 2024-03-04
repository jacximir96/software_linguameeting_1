<?php

namespace App\Src\CoachDomain\CoachHelp\Service;

use App\Src\CoachDomain\CoachHelp\Model\CoachHelp;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class CoachHelpForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $typeOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->typeOptions = [];
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configForCreate()
    {

        $this->action = route('post.admin.coach.help.create');

        $this->model = [];

        $this->typeOptions = $this->fieldFormBuilder->obtainCoachHelpTypeOptions();
    }

    public function configForEdit(CoachHelp $coachHelp)
    {

        $this->isEdit = true;

        $this->action = route('post.admin.coach.help.update', $coachHelp->hashId());

        $this->model = $coachHelp->toArray();

        $this->typeOptions = $this->fieldFormBuilder->obtainCoachHelpTypeOptions();
    }
}
