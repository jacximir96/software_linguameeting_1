<?php

namespace App\Src\CourseDomain\CoachingForm\Action\CourseAssignment;

use App\Src\CourseDomain\Assignment\Action\Command\BuilderAssignmentCommand;
use App\Src\CourseDomain\Assignment\Action\Command\ChapterCommand;
use App\Src\CourseDomain\Assignment\Action\Week\AssignGuidesToSectionWeekAction;
use App\Src\CourseDomain\CoachingForm\Request\AssignmentRequest;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\CourseDomain\Section\Model\Section;

class OneGuideForFlexSmallGroupUpdateAction
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

    public function handle(AssignmentRequest $request, Section $section, FlexSession $flexSession)
    {
        $course = $section->course;

        foreach ($course->section as $section) {

            $assignment = $this->builderAssignmentCommand->buildForFlex($section, $flexSession);

            $chapterId = $request->chapter_id;

            if ($chapterId) {
                $this->chapterCommand->assignChapterToAssignment($assignment, $chapterId);

            } else {
                $this->chapterCommand->removeChapterFromAssignment($assignment);
            }

        }
    }
}
