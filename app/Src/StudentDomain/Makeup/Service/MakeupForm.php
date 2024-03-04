<?php

namespace App\Src\StudentDomain\Makeup\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\StudentDomain\Makeup\Model\Makeup;

class MakeupForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configToCreate(Enrollment $enrollment)
    {
        $this->action = route('post.admin.student.makeup.create', $enrollment);

        $this->model = [];

    }

    public function configToEdit(Makeup $makeup)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.student.makeup.update', $makeup);

        $this->model['is_free'] = $makeup->isFree();

    }
}
