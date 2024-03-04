<?php

namespace App\Src\CoachDomain\SalaryDomain\Discount\Service;

use App\Src\CoachDomain\SalaryDomain\Discount\Model\Discount;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;
use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class DiscountForm extends BaseSearchForm
{
    //construct
    private FieldFormBuilder $fieldFormBuilder;

    private LinguaMoney $linguaMoney;

    //status
    private array $typeOptions;

    public function __construct(FieldFormBuilder $fieldFormBuilder, LinguaMoney $linguaMoney)
    {

        $this->fieldFormBuilder = $fieldFormBuilder;
        $this->linguaMoney = $linguaMoney;
        $this->discountFrequencies = collect();
        $this->typeOptions = [];
    }

    public function optionsField(string $field): array
    {
        return $this->$field;
    }

    public function configForCreate(User $coach)
    {

        $this->action = route('post.admin.coach.billing.discount.create', $coach->hashId());

        $this->model = [];

        $this->configOptions();
    }

    public function configForEdit(Discount $discount)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.coach.billing.discount.update', $discount->hashId());

        $this->model = $discount->toArray();
        $this->model['date'] = $discount->date->toDateString();
        $this->model['value'] = $this->linguaMoney->formatForFormField($discount->value);

        $this->configOptions();
    }

    private function configOptions()
    {

        $this->typeOptions = $this->fieldFormBuilder->obtainDiscountTypeOptions();
    }
}
