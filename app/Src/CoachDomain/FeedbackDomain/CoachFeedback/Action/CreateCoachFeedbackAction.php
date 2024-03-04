<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Action;

use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Model\CoachFeedback;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Request\CoachFeedbackRequest;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;

class CreateCoachFeedbackAction
{
    private ProcessCoachFeedbackRequest $processCoachFeedbackRequest;

    public function __construct(ProcessCoachFeedbackRequest $processCoachFeedbackRequest)
    {

        $this->processCoachFeedbackRequest = $processCoachFeedbackRequest;
    }

    public function handle(CoachFeedbackRequest $request, User $coach): CoachFeedback
    {

        $coachFeedback = new CoachFeedback();
        $coachFeedback->coach_id = $coach->id;
        $coachFeedback->moment = Carbon::now();

        return $this->processCoachFeedbackRequest->handle($request, $coachFeedback);
    }
}
