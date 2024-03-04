<?php

namespace App\Src\ThirdPartiesDomain\Jira\Service;

use App\Src\HelpDomain\IssueType\Model\IssueType;
use App\Src\Shared\Model\ValueObject\Url;

class IssueDto
{
    private IssueType $issueType;

    private string $name;

    private string $lastname;

    private string $email;

    private string $summary;

    private string $description;

    private ?Url $imageUrl;

    public function __construct(IssueType $issueType, string $name, string $lastname, string $email, string $summary, string $description, ?Url $imageUrl)
    {

        $this->issueType = $issueType;
        $this->name = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->summary = $summary;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
    }

    public function getIssueType(): IssueType
    {
        return $this->issueType;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getSummary(): string
    {
        return $this->summary;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function hasImageUrl(): bool
    {
        return ! is_null($this->imageUrl);
    }

    public function getImageUrl(): ?Url
    {
        return $this->imageUrl;
    }

    public function descriptionExtend(): string
    {

        if ($this->hasImageUrl()) {
            return 'Name: '.$this->name."\nEmail: ".$this->email."\nIssue: ".$this->description."\nImage Issue: ".$this->imageUrl->get();
        }

        return 'Name: '.$this->name."\nEmail: ".$this->email."\nIssue: ".$this->description;
    }
}
