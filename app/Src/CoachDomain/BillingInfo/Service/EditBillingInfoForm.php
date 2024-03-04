<?php

namespace App\Src\CoachDomain\BillingInfo\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\Shared\Service\FieldFormBuilder;
use App\Src\UserDomain\User\Model\User;

class EditBillingInfoForm extends BaseSearchForm
{
    const SLUG = 'coach_billing_profile_edit';

    private FieldFormBuilder $fieldFormBuilder;

    private array $paymentsOptions;

    private array $currenciesOptions;

    private array $countryOptions;

    private array $accountTypeOptions;

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
        $this->isEdit = true;

        $this->action = route('post.coach.billing.profile.update');

        $this->configModel($coach);

        $this->configOptions();
    }

    private function configModel(User $coach)
    {

        $this->model = [];

        if (! $coach->billingInfo) {
            return;
        }

        $this->model = $coach->billingInfo->toArray();
    }

    private function configOptions()
    {

        $this->paymentsOptions = $this->fieldFormBuilder->obtainMethodPaymentsOptions();

        $this->currenciesOptions = $this->fieldFormBuilder->obtainCurrencyOptions();

        $this->countryOptions = $this->fieldFormBuilder->obtainCountryOptions();

        $this->accountTypeOptions = $this->fieldFormBuilder->obtainAccountTypeOptions();
    }
}
