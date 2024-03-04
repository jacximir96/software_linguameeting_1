<?php

namespace App\Src\Config\Service;

use App\Src\Config\Model\Config;
use App\Src\Shared\Service\BaseSearchForm;

class ChatJiraForm extends BaseSearchForm
{
    public function config(Config $config = null)
    {
        $this->isEdit = true;

        $this->action = route('post.admin.config.jira.chat.edit');

        $this->model = $config->toArray();
    }
}
