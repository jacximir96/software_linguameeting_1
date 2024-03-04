<?php

namespace App\Src\Config\Action;

use App\Src\Config\Model\Config;
use App\Src\Config\Request\ChatJiraRequest;
use App\Src\Config\Request\EditInfoPaidRequest;

class UpdateChatJiraAction
{
    public function handle(ChatJiraRequest $request, Config $config): Config
    {
        $config->enable_chat = $request->enable_chat ?? false;

        $config->start_chat_at = null;
        if ($request->start_chat_at){
            $config->start_chat_at = $request->start_chat_at;
        }

        $config->end_chat_at = null;
        if ($request->end_chat_at){
            $config->end_chat_at = $request->end_chat_at;
        }

        $config->save();

        return $config;
    }
}
