<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service;

class FeedbackSubtypeWrapper
{
    private array $data;

    public function __construct(array $data)
    {

        $this->data = $data;
    }

    public function id(): int
    {
        return $this->data['id_sub_feed'];
    }

    public function suggestionId(): int
    {
        return $this->data['suggestion'];
    }

    public function observationId(): int
    {
        return $this->data['observation'];
    }

    public function alternativeText(): string
    {
        return $this->data['alternative_text'];
    }

    public function hasAlternativeText(): bool
    {

        if (! isset($this->data['alternative_text'])) {
            return false;
        }

        return ! empty($this->data['alternative_text']);
    }
}

/*
 "suggestion" => "0"
  "id_sub_feed" => "1"
  "observation" => "1"
  "alternative_text" => ""
 */
