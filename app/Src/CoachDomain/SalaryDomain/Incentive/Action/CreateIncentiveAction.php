<?php

namespace App\Src\CoachDomain\SalaryDomain\Incentive\Action;

use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;
use App\Src\CoachDomain\SalaryDomain\Incentive\Request\IncentiveRequest;
use App\Src\UserDomain\User\Model\User;

class CreateIncentiveAction
{
    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {

        $this->processRequest = $processRequest;
    }

    public function handle(IncentiveRequest $request, User $coach): Incentive
    {

        $incentive = new Incentive();
        $incentive->coach_id = $coach->id;

        $currency = $coach->billingInfo->currency;

        return $this->processRequest->handle($request, $incentive, $currency);
    }
}
