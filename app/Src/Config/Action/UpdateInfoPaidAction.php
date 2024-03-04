<?php

namespace App\Src\Config\Action;

use App\Src\Config\Model\Config;
use App\Src\Config\Request\EditInfoPaidRequest;

class UpdateInfoPaidAction
{
    public function handle(EditInfoPaidRequest $request, Config $config): Config
    {

        $config->paid_info = $request->paid_info;
        $config->save();

        return $config;
    }
}
