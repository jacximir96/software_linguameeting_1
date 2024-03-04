<?php
namespace App\Src\ConversationPackageDomain\Package\Action;

use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\ConversationPackageDomain\Package\Request\ConversationPackageRequest;

class CreateConversationPackageAction
{

    private ProcessRequest $processRequest;

    public function __construct (ProcessRequest $processRequest){

        $this->processRequest = $processRequest;
    }

    public function handle(ConversationPackageRequest $request):ConversationPackage{

        $conversationPackage = new  ConversationPackage();

        return $this->processRequest->handle($request, $conversationPackage);

    }
}
