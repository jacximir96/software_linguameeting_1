<?php

namespace App\Src\CourseDomain\Assignment\Action\Command;

use App\Src\CourseDomain\Assignment\Action\DeleteAssignmentAction;
use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\AssignmentFile\Action\DeleteAssignmentFileAction;
use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\CourseDomain\Section\Model\Section;

class ReplicateAssignmentCommand
{
    private Assignment $originalAssignment;

    private ?AssignmentFile $originalAssignmentFile;

    private AssignmentRepository $assignmentRepository;

    private DeleteAssignmentFileAction $deleteAssignmentFileAction;

    private DeleteAssignmentAction $deleteAssignmentAction;

    private ChapterCommand $chapterCommand;

    public function __construct(AssignmentRepository $assignmentRepository, DeleteAssignmentFileAction $deleteAssignmentFileAction, DeleteAssignmentAction $deleteAssignmentAction,
        ChapterCommand $chapterCommand)
    {

        $this->assignmentRepository = $assignmentRepository;
        $this->deleteAssignmentFileAction = $deleteAssignmentFileAction;
        $this->deleteAssignmentAction = $deleteAssignmentAction;
        $this->chapterCommand = $chapterCommand;
    }

    public function replicateForWeek(Assignment $originalAssignment, Section $toSection, CoachingWeek $toCoachingWeek)
    {

        $this->initialize($originalAssignment);

        $this->runReplicateForWeek($toSection, $toCoachingWeek);
    }

    public function replicateForFlex(Assignment $originalAssignment, Section $toSection, FlexSession $toFlexSession)
    {
        $this->initialize($originalAssignment);

        $this->runReplicateForFlex($toSection, $toFlexSession);
    }

    private function initialize(Assignment $originalAssignment)
    {
        $this->originalAssignment = $originalAssignment;
        $this->originalAssignmentFile = $originalAssignment->file;
    }

    private function runReplicateForWeek(Section $section, CoachingWeek $coachingWeek)
    {

        $assignment = $this->assignmentRepository->findBySectionAndCoachingWeekOrNull($section, $coachingWeek);

        if ($assignment) {
            $this->deleteAssignmentAction->handle($assignment);
        }

        $newAssignment = $this->createWeekAssignment($section, $coachingWeek);

        $this->updateFile($newAssignment);

        $this->assignChapter($newAssignment);
    }

    private function runReplicateForFlex(Section $section, FlexSession $flexSession)
    {

        $assignment = $this->assignmentRepository->findBySectionAndFlexOrderOrNull($section, $flexSession->number());

        if ($assignment) {
            $this->deleteAssignmentAction->handle($assignment);
        }

        $newAssignment = $this->createFlexAssignment($section, $flexSession);

        $this->updateFile($newAssignment);

        $this->assignChapter($newAssignment);
    }

    private function createWeekAssignment(Section $section, CoachingWeek $coachingWeek): Assignment
    {

        $assignment = $this->assignmentRepository->instanceForWeek($section, $coachingWeek);

        return $this->completAssignment($assignment);
    }

    private function createFlexAssignment(Section $section, FlexSession $flexSession): Assignment
    {

        $assignment = $this->assignmentRepository->instanceForFlex($section, $flexSession);

        return $this->completAssignment($assignment);
    }

    private function updateAssignment(Assignment $assignment): Assignment
    {

        $assignment->activity_name = $this->originalAssignment->activity_name;
        $assignment->activity_description = $this->originalAssignment->activity_description;
        $assignment->coach_note = $this->originalAssignment->coach_note;

        $assignment->save();

        return $assignment;
    }

    private function completAssignment(Assignment $assignment): Assignment
    {

        $assignment->activity_name = $this->originalAssignment->activity_name;
        $assignment->activity_description = $this->originalAssignment->activity_description;
        $assignment->coach_note = $this->originalAssignment->coach_note;

        $assignment->save();

        return $assignment;
    }

    private function assignChapter(Assignment $newAssignment)
    {

        $chapterAssigned = $this->originalAssignment->chapter;

        if ($chapterAssigned) {
            $this->chapterCommand->assignChapterToAssignment($newAssignment, $chapterAssigned->chapter_id);
        }

    }

    private function updateFile(Assignment $assignment)
    {

        if ($this->originalAssignmentFile) {
            $this->deleteFile($assignment);
            $this->cloneFile($assignment);
        } else {
            $this->deleteFile($assignment);
        }
    }

    private function deleteFile(Assignment $assignment)
    {

        if ($assignment->file) {
            $this->deleteAssignmentFileAction->handle($assignment->file);
        }
    }

    private function cloneFile(Assignment $assignment)
    {

        $fileCloned = new AssignmentFile();
        $fileCloned->assignment_id = $assignment->id;
        $fileCloned->filename = $this->originalAssignmentFile->filename;
        $fileCloned->original_name = $this->originalAssignmentFile->original_name;
        $fileCloned->mime = $this->originalAssignmentFile->mime;

        $fileCloned->save();
    }
}
