<?php

namespace App\Src\ThirdPartiesDomain\Jira\Action\Command;

use App\Src\HelpDomain\Issue\Model\Issue;
use App\Src\Shared\Model\ValueObject\Url;
use App\Src\ThirdPartiesDomain\Jira\Service\IssueDto;
use App\Src\ThirdPartiesDomain\Jira\Service\Jira;

class SendIssueCommand
{
    private Jira $jira;

    public function __construct(Jira $jira)
    {

        $this->jira = $jira;
    }

    public function handle(Issue $issue)
    {
        $user = $issue->user;

        $url = $this->obtainIssueFileUrl($issue);

        $dto = new IssueDto($issue->type,
            $user->name,
            $user->lastname,
            $user->email,
            $issue->summary,
            $issue->description,
            $url
        );

        $response = $this->jira->sendRequest($dto);

    }

    private function obtainIssueFileUrl(Issue $issue): ?Url
    {

        if (! $issue->file->count()) {
            return null;
        }

        return $issue->file->first()->url();
    }
}
