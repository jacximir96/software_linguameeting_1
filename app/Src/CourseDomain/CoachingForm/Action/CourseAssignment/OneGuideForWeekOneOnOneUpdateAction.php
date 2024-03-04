<?php

namespace App\Src\CourseDomain\CoachingForm\Action\CourseAssignment;

use App\Src\CourseDomain\Assignment\Action\Command\BuilderAssignmentCommand;
use App\Src\CourseDomain\Assignment\Action\Command\ChapterCommand;
use App\Src\CourseDomain\CoachingForm\Request\AssignmentRequest;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Section\Model\Section;

class OneGuideForWeekOneOnOneUpdateAction
{
    private ChapterCommand $chapterCommand;

    private BuilderAssignmentCommand $builderAssignmentCommand;

    public function __construct(ChapterCommand $chapterCommand, BuilderAssignmentCommand $builderAssignmentCommand)
    {
        $this->chapterCommand = $chapterCommand;
        $this->builderAssignmentCommand = $builderAssignmentCommand;
    }

    public function handle(AssignmentRequest $request, Section $section, CoachingWeek $coachingWeek)
    {

        $assignment = $this->builderAssignmentCommand->buildForWeek($section, $coachingWeek);

        if ($request->filled('chapter_id')) {
            $this->chapterCommand->assignChapterToAssignment($assignment, $request->chapter_id);
        } else {
            $this->chapterCommand->removeChapterFromAssignment($assignment);
        }
    }
}
