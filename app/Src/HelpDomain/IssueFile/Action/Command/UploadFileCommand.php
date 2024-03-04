<?php

namespace App\Src\HelpDomain\IssueFile\Action\Command;

use App\Src\File\Command\UploadLocalFileCommand;
use App\Src\HelpDomain\IssueFile\Model\IssueFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileCommand
{
    private UploadLocalFileCommand $uploadLocalFileCommand;

    public function __construct(UploadLocalFileCommand $uploadLocalFileCommand)
    {
        $this->uploadLocalFileCommand = $uploadLocalFileCommand;
    }

    public function handle(IssueFile $issueFile, UploadedFile $file): IssueFile
    {
        return $this->uploadLocalFileCommand->handle($file, $issueFile);
    }
}
