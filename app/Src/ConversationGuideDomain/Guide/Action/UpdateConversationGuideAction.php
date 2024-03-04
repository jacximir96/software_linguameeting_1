<?php

namespace App\Src\ConversationGuideDomain\Guide\Action;

use App\Src\ConversationGuideDomain\Guide\Model\ConversationGuide;
use App\Src\ConversationGuideDomain\Guide\Request\ConversationGuideRequest;

class UpdateConversationGuideAction
{
    public function handle(ConversationGuideRequest $request, ConversationGuide $guide): ConversationGuide
    {

        $guide->name = $request->name;
        $guide->save();

        return $guide;
    }
}
