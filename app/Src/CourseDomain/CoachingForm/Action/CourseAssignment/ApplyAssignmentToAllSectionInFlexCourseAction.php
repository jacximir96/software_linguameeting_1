<?php

namespace App\Src\CourseDomain\CoachingForm\Action\CourseAssignment;

use App\Src\CourseDomain\Assignment\Action\Command\ReplicateAssignmentCommand;
use App\Src\CourseDomain\CoachingForm\Request\AssignmentForAllRequest;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\CourseDomain\Section\Model\Section;

class ApplyAssignmentToAllSectionInFlexCourseAction
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

                $flexSession = new FlexSession($assignment->session_order);

                $this->replicateAssignmentCommand->replicateForFlex($assignment, $section, $flexSession);
            }
        }
    }

    private function configSection(AssignmentForAllRequest $request)
    {
        $this->section = Section::find($request->section_id);
    }
}
