<?php

namespace App\Src\CourseDomain\CoachingWeek\Action;

use App\Src\CourseDomain\Assignment\Action\DeleteAssignmentAction;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;

class DeleteCoachingWeekAction
{
    private DeleteAssignmentAction $deleteAssignmentAction;

    public function __construct(DeleteAssignmentAction $deleteAssignmentAction)
    {

        $this->deleteAssignmentAction = $deleteAssignmentAction;
    }

    public function handle(CoachingWeek $coachingWeek)
    {

        $this->deleteAssignment($coachingWeek);

        $coachingWeek->delete();

    }

    private function deleteAssignment(CoachingWeek $coachingWeek)
    {

        foreach ($coachingWeek->assignment as $assignment) {
            $this->deleteAssignmentAction->handle($assignment);
        }
    }
}
