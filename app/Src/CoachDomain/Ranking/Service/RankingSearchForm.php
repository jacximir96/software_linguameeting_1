<?php

namespace App\Src\CoachDomain\Ranking\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class RankingSearchForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $languageOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config()
    {

        $this->action = route('post.admin.coach.ranking.search');

        $this->model = [];

        $this->configOptions();
    }

    private function configOptions()
    {

        $this->languageOptions = $this->fieldFormBuilder->obtainLanguageOptions();
    }
}
