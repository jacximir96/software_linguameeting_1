<?php

namespace App\Src\CoachDomain\SalaryDomain\Incentive\Action;

use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;
use App\Src\CoachDomain\SalaryDomain\Incentive\Request\IncentiveRequest;

class UpdateIncentiveAction
{
    private ProcessRequest $processRequest;

    public function __construct(ProcessRequest $processRequest)
    {

        $this->processRequest = $processRequest;
    }

    public function handle(IncentiveRequest $request, Incentive $incentive): Incentive
    {

        $currency = $incentive->coach->billingInfo->currency;

        return $this->processRequest->handle($request, $incentive, $currency);
    }
}
