<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class SearchBillingForOneForm extends BaseSearchForm
{
    //construct
    private array $monthsOptions;

    private FieldFormBuilder $fieldFormBuilder;

    public function __construct(FieldFormBuilder $fieldFormBuilder)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function config(User $coach)
    {

        $this->action = route('post.admin.coach.billing.for_one.filter', $coach->hashId());

        $this->model = request()->all();

        $this->monthsOptions = $this->fieldFormBuilder->obtainMonthsOptions();
    }
}
