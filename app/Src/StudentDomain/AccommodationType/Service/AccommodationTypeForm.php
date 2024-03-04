<?php

namespace App\Src\StudentDomain\AccommodationType\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\StudentDomain\AccommodationType\Model\AccommodationType;

class AccommodationTypeForm extends BaseSearchForm
{
    //construct
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

        $this->action = route('post.admin.config.accommodation_type.create');

        $this->model = [];

        $this->typeOptions = $this->fieldFormBuilder->obtainAccommodationTypeOptions();
    }

    public function configForEdit(AccommodationType $accommodationType)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.config.accommodation_type.update', $accommodationType->hashId());

        $this->model = $accommodationType->toArray();

        $this->typeOptions = $this->fieldFormBuilder->obtainAccommodationTypeOptions();
    }
}
