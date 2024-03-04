<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Action;

use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;

class DeleteCoachFeedbackAction
{
    public function handle(CoachFeedback $coachFeedback): CoachFeedback
    {

        $coachFeedback->delete();

        return $coachFeedback;
    }
}
