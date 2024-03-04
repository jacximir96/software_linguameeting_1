<?php

namespace App\Src\CourseDomain\CoachingForm\Action\CourseAssignment;

use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;
use Illuminate\Http\UploadedFile;

trait ForAllTrait
{
    protected function updateAssignment(int $sessionOrder)
    {

        $this->assignment->instructions = $this->request->obtainInstructions($sessionOrder);
        $this->assignment->instructions_students = $this->request->obtainInstructionsStudents($sessionOrder);

        $this->assignment->share_only_coach = true;
        if ($this->request->canStudentAccess($sessionOrder)) {
            $this->assignment->share_only_coach = false;
        }

        $this->assignment->save();
    }

    protected function isFirstAssignmentFileCreated(): bool
    {
        return is_null($this->assignmentFile);
    }

    protected function fileInFieldForAllSessions()
    {
        $field = 'assignment_for_all_'.$this->section->id;

        return $this->request->$field;
    }

    protected function uploadFile(UploadedFile $file)
    {
        $this->assignmentFile = $this->uploadFile->handle($this->assignment, $file);
    }

    protected function replicateAssignmentFile()
    {
        $assignmentFile = $this->assignmentFileRepository->findByAssignment($this->assignment);

        if (is_null($assignmentFile)) {
            $assignmentFile = new AssignmentFile();
            $assignmentFile->assignment_id = $this->assignment->id;
        }

        $assignmentFile->original_name = $this->assignmentFile->original_name;
        $assignmentFile->filename = $this->assignmentFile->filename;
        $assignmentFile->mime = $this->assignmentFile->mime;

        $assignmentFile->save();

    }
}
