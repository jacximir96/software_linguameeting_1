<?php

namespace App\Src\CourseDomain\Assignment\Action\Flex;

use App\Src\CourseDomain\Assignment\Action\Command\ReplicateAssignmentCommand;
use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\CoachingForm\Request\GuideRequest;
use App\Src\CourseDomain\Section\Model\Section;

class ApplyAssignmentsFlexInAllSectionActions
{
    private AssignmentRepository $assignmentRepository;

    private AssignGuidesToSectionFlexAction $assignGuidesToSectionFlexAction;

    private ReplicateAssignmentCommand $replicateAssignmentCommand;

    public function __construct(AssignmentRepository $assignmentRepository,
        AssignGuidesToSectionFlexAction $assignGuidesToSectionFlexAction,
        ReplicateAssignmentCommand $replicateAssignmentCommand)
    {

        $this->assignmentRepository = $assignmentRepository;
        $this->assignGuidesToSectionFlexAction = $assignGuidesToSectionFlexAction;
        $this->replicateAssignmentCommand = $replicateAssignmentCommand;
    }

    public function handle(GuideRequest $request, Section $section)
    {

        $this->assignGuideToOtherSections($request, $section);

        $this->assignAssignmentsToOtherSections($section);
    }

    private function assignGuideToOtherSections(GuideRequest $request, Section $section)
    {

        $course = $section->course;

        foreach ($course->section as $section) {
            $this->assignGuidesToSectionFlexAction->handle($request, $section);
        }
    }

    private function assignAssignmentsToOtherSections(Section $originSection)
    {

        $course = $originSection->course;

        $sessions = $course->obtainFlexSessions();

        foreach ($course->section as $section) {

            if ($originSection->isSame($section)) {
                continue;
            }

            foreach ($sessions->get() as $flexSession) {

                $originalAssignment = $this->assignmentRepository->findBySectionAndFlexOrderOrNull($originSection, $flexSession->number());

                $this->replicateAssignmentCommand->replicateForFlex($originalAssignment, $section, $flexSession);
            }
        }
    }
}
