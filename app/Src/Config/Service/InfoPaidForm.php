<?php

namespace App\Src\Config\Service;

use App\Src\Config\Model\Config;
use App\Src\Shared\Service\BaseSearchForm;

class InfoPaidForm extends BaseSearchForm
{
    public function config(Config $config = null)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.coach.billing.config.invoice.info_paid.update');

        $this->model['paid_info'] = '';
        if ($config) {
            $this->model['paid_info'] = $config->paid_info;
        }
    }
}
