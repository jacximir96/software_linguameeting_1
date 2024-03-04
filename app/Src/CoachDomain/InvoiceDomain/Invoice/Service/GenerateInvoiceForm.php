<?php

namespace App\Src\CoachDomain\InvoiceDomain\Invoice\Service;

use App\Src\Shared\Service\BaseSearchForm;
use App\Src\TimeDomain\Month\Service\Month;
use App\Src\UserDomain\User\Model\User;

class GenerateInvoiceForm extends BaseSearchForm
{
    public function config(User $coach, Month $month)
    {

        $this->action = route('post.admin.coach.billing.invoice.generate_download.from_request', $coach->hashId());

        $this->model['month'] = $month->month();
        $this->model['year'] = $month->year();

    }
}
