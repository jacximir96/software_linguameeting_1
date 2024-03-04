<?php

namespace App\Src\CourseDomain\Assignment\Repository;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\SessionDomain\Session\Service\SessionOrder;

class AssignmentRepository
{
    public function instanceForWeek(Section $section, CoachingWeek $coachingWeek): Assignment
    {

        $assignment = new Assignment();
        $assignment->section_id = $section->id;
        $assignment->week_id = $coachingWeek->id;

        return $assignment;
    }

    public function instanceForFlex(Section $section, FlexSession $flexSession)
    {

        $assignment = new Assignment();
        $assignment->section_id = $section->id;
        $assignment->week_id = null;
        $assignment->session_order = $flexSession->number();

        return $assignment;
    }

    public function findBySectionAndCoachingWeekOrNull(Section $section, CoachingWeek $coachingWeek)
    {
        return Assignment::query()
            ->with('chapter', 'file')
            ->where('section_id', $section->id)
            ->where('week_id', $coachingWeek->id)
            ->first();
    }

    public function findBySectionAndFlexOrderOrNull(Section $section, int $order)
    {
        return Assignment::query()
            ->with('chapter', 'file')
            ->where('section_id', $section->id)
            ->where('session_order', $order)
            ->first();
    }

    public function findByCoachingWeek(CoachingWeek $coachingWeek)
    {
        return Assignment::where('week_id', $coachingWeek->id)->first();
    }

    public function findBySectionAndSessionOrder(Section $section, SessionOrder $sessionOrder)
    {
        return Assignment::query()
            ->where('section_id', $section->id)
            ->where('session_order', $sessionOrder->get())
            ->first();
    }
}
