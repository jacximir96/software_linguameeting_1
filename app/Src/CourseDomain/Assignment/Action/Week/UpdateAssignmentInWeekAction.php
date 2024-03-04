<?php

namespace App\Src\CourseDomain\Assignment\Action\Week;

use App\Src\CourseDomain\Assignment\Action\Command\ReplicateAssignmentCommand;
use App\Src\CourseDomain\Assignment\Action\Command\UpdateAssignmentCommand;
use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\Assignment\Request\FormAssignmentRequest;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Section\Model\Section;

class UpdateAssignmentInWeekAction
{
    private UpdateAssignmentCommand $updateAssignmentCommand;

    private ReplicateAssignmentCommand $replicateAssignmentCommand;

    public function __construct(UpdateAssignmentCommand $updateAssignmentCommand, ReplicateAssignmentCommand $replicateAssignmentCommand)
    {
        $this->updateAssignmentCommand = $updateAssignmentCommand;
        $this->replicateAssignmentCommand = $replicateAssignmentCommand;
    }

    public function handle(FormAssignmentRequest $request, Section $section, CoachingWeek $coachingWeek): Assignment
    {

        $assignment = $this->updateAssignmentCommand->updateForWeek($request, $section, $coachingWeek);

        $course = $section->course;

        if ($course->conversationPackage->sessionType->isSmallGroup()) {
            $this->replicateAssignmentToOtherSections($assignment, $section, $coachingWeek);
        }

        return $assignment;
    }

    //copiar assignment a la misma semana de otras secciones del curso
    private function replicateAssignmentToOtherSections(Assignment $assignment, Section $originalSection, CoachingWeek $coachingWeek)
    {

        $course = $originalSection->course;

        foreach ($course->section as $section) {

            if ($originalSection->isSame($section)) {
                continue;
            }

            $this->replicateAssignmentCommand->replicateForWeek($assignment, $section, $coachingWeek);
        }
    }
}
