<?php

namespace App\Src\CourseDomain\Assignment\Action\Week;

use App\Src\CourseDomain\Assignment\Action\Command\BuilderAssignmentCommand;
use App\Src\CourseDomain\Assignment\Action\Command\ChapterCommand;
use App\Src\CourseDomain\CoachingForm\Request\GuideRequest;
use App\Src\CourseDomain\Section\Model\Section;

class AssignGuidesToSectionWeekAction
{
    private ChapterCommand $chapterCommand;

    private BuilderAssignmentCommand $builderAssignmentCommand;

    public function __construct(BuilderAssignmentCommand $builderAssignmentCommand, ChapterCommand $chapterCommand)
    {
        $this->builderAssignmentCommand = $builderAssignmentCommand;
        $this->chapterCommand = $chapterCommand;
    }

    public function handle(GuideRequest $request, Section $section)
    {

        $coachingWeeks = $section->course->coachingWeeksOrderedWithoutMakeUps();

        foreach ($coachingWeeks as $coachingWeek) {

            $assignment = $this->builderAssignmentCommand->buildForWeek($section, $coachingWeek);

            $chapterId = $request->chapter_id[$coachingWeek->id]; //has selected

            if ($chapterId) {
                $this->chapterCommand->assignChapterToAssignment($assignment, $chapterId);

            } else {
                $this->chapterCommand->removeChapterFromAssignment($assignment);
            }
        }
    }
}
