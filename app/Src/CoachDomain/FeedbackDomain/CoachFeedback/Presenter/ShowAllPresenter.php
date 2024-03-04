<?php

namespace App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Presenter;

use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Repository\CoachFeedbackRepository;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service\CoachFeedbackWrapper;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service\Feedbacks;
use App\Src\UserDomain\User\Model\User;

class ShowAllPresenter
{
    private CoachFeedbackRepository $coachFeedbackRepository;

    public function __construct(CoachFeedbackRepository $coachFeedbackRepository)
    {

        $this->coachFeedbackRepository = $coachFeedbackRepository;
    }

    public function handle(User $coach): ShowAllResponse
    {

        $feedbacksResult = $this->coachFeedbackRepository->obtainFromCoachPaginate($coach, 10);

        $feedbacks = new Feedbacks();
        foreach ($feedbacksResult as $feedbackResult) {

            $feedback = new CoachFeedbackWrapper($feedbackResult);
            $feedbacks->add($feedback);
        }

        return new ShowAllResponse($feedbacks, $feedbacksResult);
    }
}
