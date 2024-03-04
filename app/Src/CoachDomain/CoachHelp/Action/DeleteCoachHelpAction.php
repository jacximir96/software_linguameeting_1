<?php

namespace App\Src\CoachDomain\CoachHelp\Action;

use App\Src\CoachDomain\CoachHelp\Model\CoachHelp;

class DeleteCoachHelpAction
{
    public function handle(CoachHelp $coachHelp): CoachHelp
    {

        $coachHelp->delete();

        return $coachHelp;
    }
}
