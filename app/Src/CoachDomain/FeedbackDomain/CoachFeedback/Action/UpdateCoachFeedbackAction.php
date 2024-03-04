<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Action;

use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Request\CoachFeedbackRequest;

class UpdateCoachFeedbackAction
{
    private ProcessCoachFeedbackRequest $processCoachFeedbackRequest;

    public function __construct(ProcessCoachFeedbackRequest $processCoachFeedbackRequest)
    {

        $this->processCoachFeedbackRequest = $processCoachFeedbackRequest;
    }

    public function handle(CoachFeedbackRequest $request, CoachFeedback $coachFeedback): CoachFeedback
    {

        return $this->processCoachFeedbackRequest->handle($request, $coachFeedback);

    }
}
