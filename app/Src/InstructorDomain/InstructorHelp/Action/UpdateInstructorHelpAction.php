<?php

namespace App\Src\InstructorDomain\InstructorHelp\Action;

use App\Src\InstructorDomain\InstructorHelp\Model\InstructorHelp;
use App\Src\InstructorDomain\InstructorHelp\Request\InstructorHelpRequest;

class UpdateInstructorHelpAction
{
    public function handle(InstructorHelpRequest $request, InstructorHelp $instructorHelp): InstructorHelp
    {

        $instructorHelp->instructor_help_type_id = $request->instructor_help_type_id;
        $instructorHelp->description = $request->description;
        $instructorHelp->url = $request->url;

        $instructorHelp->save();

        return $instructorHelp;
    }
}
