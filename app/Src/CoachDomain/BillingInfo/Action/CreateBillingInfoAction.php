<?php

namespace App\Src\CoachDomain\BillingInfo\Action;

use App\Src\CoachDomain\BillingInfo\Model\BillingInfo;
use App\Src\CoachDomain\BillingInfo\Request\BillingProfileInfoRequest;
use App\Src\UserDomain\User\Model\User;

class CreateBillingInfoAction
{
    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {

        $this->processRequest = $processRequest;
    }

    public function handle(BillingProfileInfoRequest $request, User $coach): BillingInfo
    {
        $billingInfo = new BillingInfo();
        $billingInfo->user_id = $coach->id;

        return $this->processRequest->handle($request, $billingInfo);
    }
}
