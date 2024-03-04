<?php

namespace App\Src\CourseDomain\Assignment\Action\File;

use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;
use App\Src\CourseDomain\AssignmentFile\Repository\AssignmentFileRepository;
use App\Src\File\Command\UploadLocalFileCommand;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFile
{
    private Assignment $assignment;

    private AssignmentFileRepository $assignmentFileRepository;

    private UploadLocalFileCommand $uploadLocalFileCommand;

    public function __construct(AssignmentFileRepository $assignmentFileRepository, UploadLocalFileCommand $uploadLocalFileCommand)
    {
        $this->assignmentFileRepository = $assignmentFileRepository;
        $this->uploadLocalFileCommand = $uploadLocalFileCommand;
    }

    public function handle(Assignment $assignment, UploadedFile $file): AssignmentFile
    {

        $this->assignment = $assignment;

        $assignmentFile = $this->obtainAssignmentFile();

        return $this->uploadLocalFileCommand->handle($file, $assignmentFile);
    }

    private function obtainAssignmentFile(): AssignmentFile
    {

        $assignmentFile = $this->assignmentFileRepository->findByAssignment($this->assignment);

        if (is_null($assignmentFile)) {
            $assignmentFile = new AssignmentFile();
            $assignmentFile->assignment_id = $this->assignment->id;
        }

        return $assignmentFile;

    }
}
