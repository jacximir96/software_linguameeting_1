<?php

namespace App\Src\Survey\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\Survey\Model\Survey;

class SurveyForm extends BaseSearchForm
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

    public function configToCreate(string $type, int $id)
    {
        $this->action = route('post.admin.survey.create', [$type, $id]);

        $this->model = [];
    }

    public function configToEdit(Survey $survey)
    {

        $this->action = route('post.admin.survey.update', $survey->id);

        $this->model = $survey->toArray();
    }
}
