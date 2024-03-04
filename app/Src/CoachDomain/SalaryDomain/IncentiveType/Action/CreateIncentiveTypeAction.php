<?php

namespace App\Src\CoachDomain\SalaryDomain\IncentiveType\Action;

use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Request\IncentiveTypeRequest;

class CreateIncentiveTypeAction
{
    public function handle(IncentiveTypeRequest $request): IncentiveType
    {

        $incentiveType = new IncentiveType();
        $incentiveType->name = $request->name;
        $incentiveType->description = $request->description;

        $incentiveType->save();

        return $incentiveType;
    }
}
