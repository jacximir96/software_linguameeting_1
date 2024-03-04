<?php

namespace App\Src\CoachDomain\CoachHelp\Action;

use App\Src\CoachDomain\CoachHelp\Model\CoachHelp;
use App\Src\CoachDomain\CoachHelp\Request\CoachHelpRequest;

class UpdateCoachHelpAction
{
    public function handle(CoachHelpRequest $request, CoachHelp $coachHelp): CoachHelp
    {

        $coachHelp->coach_help_type_id = $request->coach_help_type_id;
        $coachHelp->description = $request->description;
        $coachHelp->url = $request->url;

        $coachHelp->save();

        return $coachHelp;
    }
}
