<?php

namespace App\Src\CoachDomain\SalaryDomain\DiscountType\Service;

use App\Src\CoachDomain\SalaryDomain\DiscountType\Model\DiscountType;
use App\Src\Shared\Service\BaseSearchForm;

class DiscountTypeForm extends BaseSearchForm
{
    public function configForCreate()
    {

        $this->action = route('post.admin.coach.billing.config.discount.options.create');

        $this->model = [];
    }

    public function configForEdit(DiscountType $discountType)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.coach.billing.config.discount.options.update', $discountType->hashId());

        $this->model = $discountType->toArray();
    }
}
