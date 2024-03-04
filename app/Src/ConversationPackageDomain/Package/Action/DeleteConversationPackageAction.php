<?php
namespace App\Src\ConversationPackageDomain\Package\Action;

use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;


class DeleteConversationPackageAction
{

    public function handle(ConversationPackage $conversationPackage):ConversationPackage{

        $conversationPackage->delete();

        return $conversationPackage;

    }
}
