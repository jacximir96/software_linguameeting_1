<?php

namespace App\Src\CoachDomain\SalaryDomain\IncentiveType\Service;

use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;
use App\Src\Shared\Service\BaseSearchForm;

class IncentiveTypeForm extends BaseSearchForm
{
    public function configForCreate()
    {

        $this->action = route('post.admin.coach.billing.config.incentive.options.create');

        $this->model = [];
    }

    public function configForEdit(IncentiveType $incentiveType)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.coach.billing.config.incentive.options.update', $incentiveType->hashId());

        $this->model = $incentiveType->toArray();
    }
}
