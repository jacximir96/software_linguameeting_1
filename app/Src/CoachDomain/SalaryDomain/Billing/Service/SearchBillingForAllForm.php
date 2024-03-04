<?php

namespace App\Src\CoachDomain\SalaryDomain\Billing\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\TimeDomain\Month\Service\Month;

class SearchBillingForAllForm extends BaseSearchForm
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

    public function configFromRequest()
    {

        $this->action = route('post.admin.coach.billing.for_all.search');

        $this->model = request()->all();

        $this->monthsOptions = $this->fieldFormBuilder->obtainMonthsOptions();
    }

    public function configFromMonth(Month $month)
    {

        $this->action = route('post.admin.coach.billing.for_all.search');

        $this->model = [
            'month' => $month->month(),
            'year' => $month->year(),
        ];

        $this->monthsOptions = $this->fieldFormBuilder->obtainMonthsOptions();
    }
}
