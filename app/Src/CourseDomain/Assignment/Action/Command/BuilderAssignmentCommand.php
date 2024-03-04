<?php

namespace App\Src\CourseDomain\Assignment\Action\Command;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\CourseDomain\Section\Model\Section;

class BuilderAssignmentCommand
{
    private AssignmentRepository $assignmentRepository;

    public function __construct(AssignmentRepository $assignmentRepository)
    {
        $this->assignmentRepository = $assignmentRepository;
    }

    public function buildForWeek(Section $section, CoachingWeek $coachingWeek): Assignment
    {

        $assignment = $this->assignmentRepository->findBySectionAndCoachingWeekOrNull($section, $coachingWeek);

        if ($assignment) {
            return $assignment;
        }

        return $this->createForWeek($section, $coachingWeek);
    }

    public function buildForFlex(Section $section, FlexSession $flexSession): Assignment
    {

        $assignment = $this->assignmentRepository->findBySectionAndFlexOrderOrNull($section, $flexSession->number());

        if ($assignment) {
            return $assignment;
        }

        return $this->createForFlex($section, $flexSession);
    }

    public function createForWeek(Section $section, CoachingWeek $coachingWeek): Assignment
    {

        $assignment = new Assignment();
        $assignment->section_id = $section->id;
        $assignment->week_id = $coachingWeek->id;

        $assignment->save();

        return $assignment;
    }

    public function createForFlex(Section $section, FlexSession $flexSession): Assignment
    {

        $assignment = new Assignment();
        $assignment->section_id = $section->id;
        $assignment->session_order = $flexSession->number();

        $assignment->save();

        return $assignment;
    }
}
