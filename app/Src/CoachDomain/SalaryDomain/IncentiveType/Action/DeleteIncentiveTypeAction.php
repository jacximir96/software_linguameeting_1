<?php

namespace App\Src\CoachDomain\SalaryDomain\IncentiveType\Action;

use App\Src\CoachDomain\SalaryDomain\IncentiveType\Model\IncentiveType;

class DeleteIncentiveTypeAction
{
    public function handle(IncentiveType $incentiveType): IncentiveType
    {

        $incentiveType->delete();

        return $incentiveType;
    }
}
