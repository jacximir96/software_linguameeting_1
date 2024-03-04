<?php

namespace App\Src\InstructorDomain\TeachingAssistant\Action;

use App\Src\InstructorDomain\TeachingAssistant\Model\TeachingAssistant;

class DeleteInstructorAssignedAction
{
    public function handle(TeachingAssistant $teachingAssistant)
    {

        $teachingAssistant->delete();
    }
}
