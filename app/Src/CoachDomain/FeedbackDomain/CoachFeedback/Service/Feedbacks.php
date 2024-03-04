<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service;

use Illuminate\Support\Collection;

class Feedbacks
{
    private Collection $feedbacks;

    public function __construct()
    {
        $this->feedbacks = collect();
    }

    public function get(): Collection
    {
        return $this->feedbacks;
    }

    public function hasFeedbacks(): bool
    {
        return $this->feedbacks->count();
    }

    public function add(CoachFeedbackWrapper $feedback)
    {
        $this->feedbacks->push($feedback);
    }
}
