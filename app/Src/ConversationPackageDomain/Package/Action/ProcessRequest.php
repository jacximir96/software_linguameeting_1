<?php


namespace App\Src\ConversationPackageDomain\Package\Action;


use App\Src\ConversationPackageDomain\Package\Model\ConversationPackage;
use App\Src\ConversationPackageDomain\Package\Request\ConversationPackageRequest;
use App\Src\PaymentDomain\Money\Service\LinguaMoney;

class ProcessRequest
{
    private LinguaMoney $linguaMoney;

    public function __construct (LinguaMoney $linguaMoney){

        $this->linguaMoney = $linguaMoney;
    }

    public function handle(ConversationPackageRequest $request, ConversationPackage $conversationPackage):ConversationPackage{

        $conversationPackage->session_type_id = $request->session_type_id;
        $conversationPackage->name = $request->name;
        $conversationPackage->number_session = $request->number_session;
        $conversationPackage->duration_session = $request->duration_session;
        $conversationPackage->isbn = $request->isbn;
        $conversationPackage->code_active = $request->code_active ?? false;
        $conversationPackage->experiences = $request->experiences ?? false;
        $conversationPackage->comments = $request->comments ?? null;
        $conversationPackage->price = $this->linguaMoney->buildFromFloat($request->price);

        $conversationPackage->save();

        return $conversationPackage;

    }
}
