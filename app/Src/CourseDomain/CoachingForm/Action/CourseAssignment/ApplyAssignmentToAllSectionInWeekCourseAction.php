<?php

namespace App\Src\CourseDomain\CoachingForm\Action\CourseAssignment;

use App\Src\CourseDomain\Assignment\Action\Command\ReplicateAssignmentCommand;
use App\Src\CourseDomain\CoachingForm\Request\AssignmentForAllRequest;
use App\Src\CourseDomain\Section\Model\Section;

class ApplyAssignmentToAllSectionInWeekCourseAction
{
    private Section $section;

    private ReplicateAssignmentCommand $replicateAssignmentCommand;

    public function __construct(ReplicateAssignmentCommand $replicateAssignmentCommand)
    {

        $this->replicateAssignmentCommand = $replicateAssignmentCommand;
    }

    public function handle(AssignmentForAllRequest $request)
    {

        $this->configSection($request);

        $course = $this->section->course;

        foreach ($course->section as $section) {

            if ($this->section->isSame($section)) {
                continue;
            }

            foreach ($this->section->assignment as $assignment) {
                $this->replicateAssignmentCommand->replicateForWeek($assignment, $section, $assignment->week);
            }
        }
    }

    private function configSection(AssignmentForAllRequest $request)
    {
        $this->section = Section::find($request->section_id);
    }
}
