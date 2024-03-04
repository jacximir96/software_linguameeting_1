<?php

namespace App\Src\HelpDomain\Issue\Action;

use App\Src\HelpDomain\Issue\Model\Issue;
use App\Src\HelpDomain\Issue\Request\IssueRequest;
use App\Src\HelpDomain\IssueFile\Action\Command\UploadFileCommand;
use App\Src\HelpDomain\IssueFile\Model\IssueFile;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class CreateIssueAction
{
    private UploadFileCommand $uploadFileCommand;

    public function __construct(UploadFileCommand $uploadFileCommand)
    {
        $this->uploadFileCommand = $uploadFileCommand;
    }

    public function handle(IssueRequest $request, User $user): Issue
    {

        $issue = new Issue();
        $issue->user_id = $user->id;
        $issue->issue_type_id = $request->issue_type_id;
        $issue->summary = $request->summary;
        $issue->description = $request->description;
        $issue->sent_at = Carbon::now();
        $issue->save();

        if ($request->file('issue_file')) {

            $file = new IssueFile();
            $file->issue_id = $issue->id;

            $this->uploadFileCommand->handle($file, $request->issue_file);
        }

        return $issue;
    }
}
