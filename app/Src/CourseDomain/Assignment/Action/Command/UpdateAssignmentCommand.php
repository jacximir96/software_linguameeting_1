<?php

namespace App\Src\CourseDomain\Assignment\Action\Command;

use App\Src\CourseDomain\Assignment\Action\File\UploadFile;
use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\Assignment\Request\FormAssignmentRequest;
use App\Src\CourseDomain\AssignmentFile\Action\DeleteAssignmentFileAction;
use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\CourseDomain\Section\Model\Section;

class UpdateAssignmentCommand
{
    private ?Assignment $assignment;

    private FormAssignmentRequest $request;

    private Section $section;

    private CoachingWeek $coachingWeek;

    private FlexSession $flexSession;

    private AssignmentRepository $assignmentRepository;

    private UploadFile $uploadFile;

    private DeleteAssignmentFileAction $deleteAssignmentFileAction;

    public function __construct(AssignmentRepository $assignmentRepository, UploadFile $uploadFile, DeleteAssignmentFileAction $deleteAssignmentFileAction)
    {

        $this->assignmentRepository = $assignmentRepository;
        $this->uploadFile = $uploadFile;
        $this->deleteAssignmentFileAction = $deleteAssignmentFileAction;
    }

    public function updateForWeek(FormAssignmentRequest $request, Section $section, CoachingWeek $coachingWeek): Assignment
    {

        $this->request = $request;
        $this->section = $section;
        $this->coachingWeek = $coachingWeek;

        $this->assignment = $this->assignmentRepository->findBySectionAndCoachingWeekOrNull($this->section, $coachingWeek);

        if (is_null($this->assignment)) {
            $this->createWeekAssignment();
        }

        $this->updateAssignment();

        $this->proccessFile();

        $this->assignment->refresh();

        return $this->assignment;
    }

    public function updateForFlex(FormAssignmentRequest $request, Section $section, FlexSession $flexSession): Assignment
    {

        $this->request = $request;
        $this->section = $section;
        $this->flexSession = $flexSession;

        $this->assignment = $this->assignmentRepository->findBySectionAndFlexOrderOrNull($this->section, $this->flexSession->number());

        if (is_null($this->assignment)) {
            $this->createFlexAssignment();
        }

        $this->updateAssignment();

        $this->proccessFile();

        $this->assignment->refresh();

        return $this->assignment;
    }

    private function updateAssignment()
    {

        $this->assignment->activity_name = $this->request->activity_name ?? null;
        $this->assignment->activity_description = $this->request->activity_description ?? null;
        $this->assignment->coach_note = $this->request->coach_note;

        $this->assignment->save();

        return $this->assignment;
    }

    private function createFlexAssignment()
    {

        $this->assignment = new Assignment();
        $this->assignment->section_id = $this->section->id;
        $this->assignment->session_order = $this->flexSession->number();
    }

    private function createWeekAssignment()
    {

        $this->assignment = new Assignment();
        $this->assignment->section_id = $this->section->id;
        $this->assignment->week_id = $this->coachingWeek->id;
    }

    private function proccessFile()
    {

        if ($this->request->hasFile('file')) {

            if ($this->assignment->file) {
                $this->deleteFile($this->assignment->file);
            }

            $this->createFile();
        }
    }

    private function deleteFile(AssignmentFile $assignmentFile)
    {
        $this->deleteAssignmentFileAction->handle($assignmentFile);
    }

    private function createFile(): AssignmentFile
    {
        return $this->uploadFile->handle($this->assignment, $this->request->file('file'));
    }
}
