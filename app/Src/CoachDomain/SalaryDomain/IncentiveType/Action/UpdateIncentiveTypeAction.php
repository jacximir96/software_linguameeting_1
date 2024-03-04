<?php

namespace App\Src\CoachDomain\SalaryDomain\IncentiveType\Action;

use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;
use App\Src\CoachDomain\SalaryDomain\IncentiveType\Request\IncentiveTypeRequest;

class UpdateIncentiveTypeAction
{
    public function handle(IncentiveTypeRequest $request, IncentiveType $incentiveType): IncentiveType
    {

        $incentiveType->name = $request->name;
        $incentiveType->description = $request->description;

        $incentiveType->save();

        return $incentiveType;
    }
}
