<?php

namespace App\Src\CoachDomain\BillingInfo\Action;

use App\Src\CoachDomain\BillingInfo\Model\BillingInfo;
use App\Src\CoachDomain\BillingInfo\Request\BillingProfileInfoRequest;
use App\Src\UserDomain\User\Model\User;

class UpdateBillingInfoAction
{
    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {

        $this->processRequest = $processRequest;
    }

    public function handle(BillingProfileInfoRequest $request, User $coach): BillingInfo
    {
        $billingInfo = $coach->billingInfo;

        return $this->processRequest->handle($request, $billingInfo);
    }
}
