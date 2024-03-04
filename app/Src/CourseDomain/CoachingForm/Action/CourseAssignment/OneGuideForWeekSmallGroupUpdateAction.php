<?php

namespace App\Src\CourseDomain\CoachingForm\Action\CourseAssignment;

use App\Src\CourseDomain\Assignment\Action\Command\BuilderAssignmentCommand;
use App\Src\CourseDomain\Assignment\Action\Command\ChapterCommand;
use App\Src\CourseDomain\Assignment\Action\Week\AssignGuidesToSectionWeekAction;
use App\Src\CourseDomain\CoachingForm\Request\AssignmentRequest;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;

class OneGuideForWeekSmallGroupUpdateAction
{
    private AssignGuidesToSectionWeekAction $assignGuidesToSectionWeekAction;

    private BuilderAssignmentCommand $builderAssignmentCommand;

    private ChapterCommand $chapterCommand;

    public function __construct(AssignGuidesToSectionWeekAction $assignGuidesToSectionWeekAction, BuilderAssignmentCommand $builderAssignmentCommand, ChapterCommand $chapterCommand)
    {
        $this->assignGuidesToSectionWeekAction = $assignGuidesToSectionWeekAction;
        $this->builderAssignmentCommand = $builderAssignmentCommand;
        $this->chapterCommand = $chapterCommand;
    }

    public function handle(AssignmentRequest $request, CoachingWeek $coachingWeek)
    {
        $course = $coachingWeek->course;

        foreach ($course->section as $section) {

            $assignment = $this->builderAssignmentCommand->buildForWeek($section, $coachingWeek);

            $chapterId = $request->chapter_id;

            if ($chapterId) {
                $this->chapterCommand->assignChapterToAssignment($assignment, $chapterId);

            } else {
                $this->chapterCommand->removeChapterFromAssignment($assignment);
            }
        }
    }
}
