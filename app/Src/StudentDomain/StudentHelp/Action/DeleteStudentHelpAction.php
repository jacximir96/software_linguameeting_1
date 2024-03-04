<?php

namespace App\Src\StudentDomain\StudentHelp\Action;

use App\Src\StudentDomain\StudentHelp\Model\StudentHelp;

class DeleteStudentHelpAction
{
    public function handle(StudentHelp $studentHelp): StudentHelp
    {

        $studentHelp->delete();

        return $studentHelp;
    }
}
