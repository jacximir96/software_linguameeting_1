<?php

namespace App\Src\StudentDomain\StudentHelp\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\StudentDomain\StudentHelp\Model\StudentHelp;

class StudentHelpForm extends BaseSearchForm
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

        $this->action = route('post.admin.student.help.create');

        $this->model = [];

        $this->typeOptions = $this->fieldFormBuilder->obtainStudentHelpTypeOptions();
    }

    public function configForEdit(StudentHelp $studentHelp)
    {

        $this->isEdit = true;

        $this->action = route('post.admin.student.help.update', $studentHelp->id);

        $this->model = $studentHelp->toArray();

        $this->typeOptions = $this->fieldFormBuilder->obtainStudentHelpTypeOptions();
    }
}
