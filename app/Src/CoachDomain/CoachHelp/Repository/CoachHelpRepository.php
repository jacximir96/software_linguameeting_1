<?php

namespace App\Src\CoachDomain\CoachHelp\Repository;

use App\Src\CoachDomain\CoachHelp\Model\CoachHelp;

class CoachHelpRepository
{
    public function all()
    {

        return CoachHelp::query()
            ->select('coach_help.*')
            ->with('type')
            ->join('coach_help_type', 'coach_help.coach_help_type_id', '=', 'coach_help_type.id')
            ->orderBy('coach_help_type.id')
            ->orderBy('coach_help.description')
            ->get();
    }
}
