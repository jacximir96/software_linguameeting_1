<?php

namespace App\Src\StudentDomain\StudentHelp\Action;

use App\Src\StudentDomain\StudentHelp\Model\StudentHelp;
use App\Src\StudentDomain\StudentHelp\Request\StudentHelpRequest;

class UpdateStudentHelpAction
{
    public function handle(StudentHelpRequest $request, StudentHelp $studentHelp): StudentHelp
    {

        $studentHelp->student_help_type_id = $request->student_help_type_id;
        $studentHelp->description = $request->description;
        $studentHelp->url = $request->url;

        $studentHelp->save();

        return $studentHelp;
    }
}
