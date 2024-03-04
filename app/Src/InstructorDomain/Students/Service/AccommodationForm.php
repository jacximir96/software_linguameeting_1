<?php

namespace App\Src\InstructorDomain\Students\Service;


use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;

class AccommodationForm extends BaseSearchForm
{

    private array $accommodationsTypesOptions = [];

    private FieldFormBuilder $fieldFormBuilder;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configForEdit(Enrollment $enrollment)
    {
        $this->isEdit = true;

        $this->action = route('post.instructor.api.students.accommodation.update', $enrollment->hashId());

        $this->model = [];
        $this->model ['has_accommodation'] = false;

        if ($enrollment->accommodation){
            $this->model = $enrollment->accommodation->toArray();
        }

        $this->accommodationsTypesOptions = $this->fieldFormBuilder->obtainAccommodationTypeOptions();
    }
}
