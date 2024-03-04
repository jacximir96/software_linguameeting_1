<?php

namespace App\Src\Config\Service;

use App\Src\Config\Model\Config;
use App\Src\Shared\Service\BaseSearchForm;

class UserForm extends BaseSearchForm
{
    public function config(Config $config = null)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.config.user.edit');

        $this->model = $config->toArray();
    }
}
