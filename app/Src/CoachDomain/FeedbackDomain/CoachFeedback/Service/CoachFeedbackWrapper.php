<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service;

use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use App\Src\Localization\Language\Model\Language;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class CoachFeedbackWrapper
{
    private CoachFeedback $coachFeedback;

    public function __construct(CoachFeedback $coachFeedback)
    {

        $this->coachFeedback = $coachFeedback;
    }

    public function get(): CoachFeedback
    {
        return $this->coachFeedback;
    }

    public function moment(): Carbon
    {
        return $this->coachFeedback->moment;
    }

    public function printMoment(): string
    {
        return $this->coachFeedback->moment->format('m/d/Y H:i:s');
    }

    public function language(): Language
    {
        return $this->coachFeedback->language;
    }

    public function hasRecordingUrl(): bool
    {
        return $this->coachFeedback->hasRecordingUrl();
    }

    public function feedbackSortedByTypes(): Collection
    {

        $feedbacks = collect();

        foreach ($this->coachFeedback->feedbacks as $feedback) {

            $wrapper = new FeedbackTypeWrapper($feedback);

            $feedbacks->put($wrapper->id(), $wrapper);

        }

        return $feedbacks;
    }
}
