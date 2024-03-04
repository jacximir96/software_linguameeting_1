<?php

namespace App\Src\CoachDomain\SalaryDomain\Salary\Service;

use App\Src\CoachDomain\SalaryDomain\Salary\Model\Salary;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class SalaryForm extends BaseSearchForm
{
    //construct
    private $salaryTypeOptions;

    private LinguaMoney $linguaMoney;

    private FieldFormBuilder $fieldFormBuilder;

    public function __construct(FieldFormBuilder $fieldFormBuilder, LinguaMoney $linguaMoney)
    {
        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->linguaMoney = $linguaMoney;
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configForCreate(User $coach)
    {

        $this->action = route('post.admin.coach.billing.salary.create', $coach->hashId());

        $this->model = [];

        $this->salaryTypeOptions = $this->fieldFormBuilder->obtainSalaryTypeOptions();
    }

    public function configForEdit(Salary $salary)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.coach.billing.salary.update', $salary->hashId());

        $this->salaryTypeOptions = $this->fieldFormBuilder->obtainSalaryTypeOptions();

        $this->configModel($salary);
    }

    private function configModel(Salary $salary)
    {

        $this->model = $salary->toArray();
        $this->model['value'] = $this->linguaMoney->formatForFormField($salary->value);

        if ($salary->hasExtraCoordinator()) {
            $this->model['extra_coordinator'] = $this->linguaMoney->formatForFormField($salary->extra_coordinator);
        }

        $coach = $salary->coach;
        $coachInfo = $coach->coachInfo;
        if ($coachInfo->isPayer()) {
            $this->model['is_payer'] = true;
        }

    }
}
