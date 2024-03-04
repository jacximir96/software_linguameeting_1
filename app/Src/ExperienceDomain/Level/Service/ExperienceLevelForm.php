<?php

namespace App\Src\ExperienceDomain\Level\Service;

use App\Src\ExperienceDomain\Level\Model\Level;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;


class ExperienceLevelForm extends BaseSearchForm
{
    //construct
    private FieldFormBuilder $fieldFormBuilder;


    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configForCreate()
    {
        $this->action = route('post.admin.config.experience_level.create');

        $this->model = [];

    }

    public function configForEdit(Level $level)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.config.experience_level.update', $level->hashId());

        $this->model = $level->toArray();
    }
}
