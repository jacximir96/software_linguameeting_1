<?php

namespace App\Src\InstructorDomain\InstructorHelp\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\InstructorDomain\InstructorHelp\Model\InstructorHelp;

class InstructorHelpForm extends BaseSearchForm
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

        $this->action = route('post.admin.instructor.help.create');

        $this->model = [];

        $this->typeOptions = $this->fieldFormBuilder->obtainInstructorHelpTypeOptions();
    }

    public function configForEdit(InstructorHelp $instructorHelp)
    {

        $this->isEdit = true;

        $this->action = route('post.admin.instructor.help.update', $instructorHelp->id);

        $this->model = $instructorHelp->toArray();

        $this->typeOptions = $this->fieldFormBuilder->obtainInstructorHelpTypeOptions();
    }
}
