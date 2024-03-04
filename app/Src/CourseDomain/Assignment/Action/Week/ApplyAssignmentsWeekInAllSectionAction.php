<?php

namespace App\Src\CourseDomain\Assignment\Action\Week;

use App\Src\CourseDomain\Assignment\Action\Command\ReplicateAssignmentCommand;
use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\CoachingForm\Request\GuideRequest;
use App\Src\CourseDomain\Section\Model\Section;

class ApplyAssignmentsWeekInAllSectionAction
{
    private AssignmentRepository $assignmentRepository;

    private AssignGuidesToSectionWeekAction $assignGuidesToSectionWeeksAction;

    private ReplicateAssignmentCommand $replicateAssignmentCommand;

    public function __construct(AssignmentRepository $assignmentRepository,
        AssignGuidesToSectionWeekAction $assignGuidesToSectionWeeksAction,
        ReplicateAssignmentCommand $replicateAssignmentCommand)
    {

        $this->assignmentRepository = $assignmentRepository;
        $this->assignGuidesToSectionWeeksAction = $assignGuidesToSectionWeeksAction;
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
            $this->assignGuidesToSectionWeeksAction->handle($request, $section);
        }
    }

    private function assignAssignmentsToOtherSections(Section $originSection)
    {

        $course = $originSection->course;

        $coachingWeeks = $course->coachingWeeksOrderedWithoutMakeUps();

        foreach ($course->section as $section) {

            if ($originSection->isSame($section)) {
                continue;
            }

            foreach ($coachingWeeks as $coachingWeek) {

                $originalAssignment = $this->assignmentRepository->findBySectionAndCoachingWeekOrNull($originSection, $coachingWeek);

                $this->replicateAssignmentCommand->replicateForWeek($originalAssignment, $section, $coachingWeek);
            }
        }
    }
}
