<?php

namespace App\Src\InstructorDomain\InstructorHelp\Action;

use App\Src\InstructorDomain\InstructorHelp\Model\InstructorHelp;

class DeleteInstructorHelpAction
{
    public function handle(InstructorHelp $instructorHelp): InstructorHelp
    {

        $instructorHelp->delete();

        return $instructorHelp;
    }
}
