<?php

namespace App\Src\CoachDomain\SalaryDomain\Incentive\Service;

use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;
use App\Src\CoachDomain\SalaryDomain\IncentiveFrequency\Model\IncentiveFrequency;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class IncentiveForm extends BaseSearchForm
{
    //construct
    private FieldFormBuilder $fieldFormBuilder;

    private LinguaMoney $linguaMoney;

    //status
    private Collection $incentiveFrequencies;

    private array $typeOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder, LinguaMoney $linguaMoney)
    {

        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->linguaMoney = $linguaMoney;
        $this->incentiveFrequencies = collect();
        $this->typeOptions = [];
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function frequencies(): Collection
    {
        return $this->incentiveFrequencies;
    }

    public function configForCreate(User $coach)
    {

        $this->action = route('post.admin.coach.billing.incentive.create', $coach->hashId());

        $this->model = [];

        $this->configOptions();
    }

    public function configForEdit(Incentive $incentive)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.coach.billing.incentive.update', $incentive->hashId());

        $this->model = $incentive->toArray();
        $this->model['date'] = $incentive->date->toDateString();
        $this->model['value'] = $this->linguaMoney->formatForFormField($incentive->value);

        $this->configOptions();
    }

    private function configOptions()
    {

        $this->incentiveFrequencies = IncentiveFrequency::orderBy('name')->get();

        $this->typeOptions = $this->fieldFormBuilder->obtainIncentiveTypeOptions();
    }
}
