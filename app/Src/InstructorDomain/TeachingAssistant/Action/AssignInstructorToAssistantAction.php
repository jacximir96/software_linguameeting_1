<?php

namespace App\Src\InstructorDomain\TeachingAssistant\Action;

use App\Src\InstructorDomain\TeachingAssistant\Model\TeachingAssistant;
use App\Src\InstructorDomain\TeachingAssistant\Request\AssignInstructorToAssistantRequest;
use App\Src\UserDomain\User\Model\User;

class AssignInstructorToAssistantAction
{
    public function handle(AssignInstructorToAssistantRequest $request, User $assistant): TeachingAssistant
    {

        $teachingAssistant = new TeachingAssistant();
        $teachingAssistant->instructor_id = $request->instructor_id;
        $teachingAssistant->assistant_id = $assistant->id;

        $teachingAssistant->save();

        return $teachingAssistant;
    }
}
