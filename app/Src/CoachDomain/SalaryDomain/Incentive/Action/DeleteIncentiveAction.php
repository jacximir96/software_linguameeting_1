<?php

namespace App\Src\CoachDomain\SalaryDomain\Incentive\Action;

use App\Src\CoachDomain\SalaryDomain\Incentive\Model\Incentive;

class DeleteIncentiveAction
{
    public function handle(Incentive $incentive): Incentive
    {

        $incentive->delete();

        return $incentive;
    }
}
