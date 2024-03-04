<?php

namespace App\Src\RegisterCodeDomain\BookstoreRequest\Service;

use App\Src\RegisterCodeDomain\BookstoreRequest\Model\BookstoreRequest;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class RequestForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $universitiesOptions = [];

    private array $courseTypeOptions = [];

    private array $experiencesCourseTypeOptions = [];

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configToCreate()
    {
        $this->action = route('post.admin.university.bookstore.request.create');

        $this->model = [];
        $this->model['max_experiences'] = 0;

        $this->universitiesOptions = $this->fieldFormBuilder->obtainUniversityOptions();

        $this->courseTypeOptions = $this->fieldFormBuilder->obtainCourseTypeOptionsWithIsbnAndPrice();

        $this->experiencesCourseTypeOptions = $this->fieldFormBuilder->obtainExperiencesCourseTypeOptionsWithIsbnAndPrice();
    }

    public function configToEdit(BookstoreRequest $request)
    {
        //$this->action = route('post.admin.university.edit', $request);

        $this->model = $request->toArray();

        $this->universitiesOptions = $this->fieldFormBuilder->obtainUniversityOptions();
    }
}
