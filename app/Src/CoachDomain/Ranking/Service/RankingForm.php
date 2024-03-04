<?php

namespace App\Src\CoachDomain\Ranking\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;

class RankingForm extends BaseSearchForm
{
    private FieldFormBuilder $fieldFormBuilder;

    private array $rankingOptions;

    private array $preferenceOptions;

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

        $this->rankingOptions = $this->fieldFormBuilder->obtainNumberOptions(1, 35);

        $this->preferenceOptions = $this->fieldFormBuilder->obtainNumberOptions(1, 100);
    }
}
