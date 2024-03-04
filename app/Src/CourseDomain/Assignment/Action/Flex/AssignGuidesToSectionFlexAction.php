<?php

namespace App\Src\CourseDomain\Assignment\Action\Flex;

use App\Src\CourseDomain\Assignment\Action\Command\BuilderAssignmentCommand;
use App\Src\CourseDomain\Assignment\Action\Command\ChapterCommand;
use App\Src\CourseDomain\CoachingForm\Request\GuideRequest;
use App\Src\CourseDomain\Section\Model\Section;

class AssignGuidesToSectionFlexAction
{
    private BuilderAssignmentCommand $builderAssignmentCommand;

    private ChapterCommand $chapterCommand;

    public function __construct(BuilderAssignmentCommand $builderAssignmentCommand, ChapterCommand $chapterCommand)
    {
        $this->builderAssignmentCommand = $builderAssignmentCommand;
        $this->chapterCommand = $chapterCommand;
    }

    public function handle(GuideRequest $request, Section $section)
    {

        $sessions = $section->course->obtainFlexSessions();

        foreach ($sessions->get() as $flexSession) {

            $assignment = $this->builderAssignmentCommand->buildForFlex($section, $flexSession);

            $chapterId = $request->chapter_id[$flexSession->number()]; //has selected

            if ($chapterId) {
                $this->chapterCommand->assignChapterToAssignment($assignment, $chapterId);

            } else {
                $this->chapterCommand->removeChapterFromAssignment($assignment);
            }
        }
    }
}
