<?php

namespace App\Src\Config\Action;

use App\Src\Config\Model\Config;
use App\Src\Config\Request\UserRequest;

class UpdateUserAction
{
    public function handle(UserRequest $request, Config $config): Config
    {
        $config->check_email_exist = $request->check_email_exist ?? false;

        $config->save();

        return $config;
    }
}
