<?php

namespace App\Src\CoachDomain\Coach\Presenter;

use App\Src\ActivityLog\Model\Activity;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Repository\CoachFeedbackRepository;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service\CoachFeedbackWrapper;
use App\Src\CoachDomain\FeedbackDomain\CoachFeedback\Service\Feedbacks;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Service\ReviewsWithStats;
use App\Src\UserDomain\User\Model\User;
use App\Src\ZoomDomain\ZoomRecording\Repository\ZoomRecordingRepository;
use Illuminate\Support\Collection;

class ShowCoachPresenter
{
    private User $coach;

    private ZoomRecordingRepository $zoomRecordingRepository;

    private CoachFeedbackRepository $coachFeedbackRepository;

    private CoachReviewRepository $coachReviewRepository;

    public function __construct(ZoomRecordingRepository $zoomRecordingRepository,
        CoachFeedbackRepository $coachFeedbackRepository,
        CoachReviewRepository $coachReviewRepository)
    {

        $this->zoomRecordingRepository = $zoomRecordingRepository;
        $this->coachFeedbackRepository = $coachFeedbackRepository;
        $this->coachReviewRepository = $coachReviewRepository;
    }

    public function handle(User $coach): ShowCoachResponse
    {

        $this->initialize($coach);

        $activity = $this->obtainActivity();

        $coordinatedCoaches = $this->obtainCoordinatedCoaches();

        $coordinatedBy = $this->obtainCoordinatorCoaches();

        $recordings = $this->obtainLastZoomRecording();

        $reviewsWithStats = $this->obtainSessionsReviews();

        $feedbacks = $this->obtainFeedbacks();

        return new ShowCoachResponse($coach, $activity, $coordinatedCoaches, $coordinatedBy, $recordings, $reviewsWithStats, $feedbacks);
    }

    private function initialize(User $coach)
    {
        $this->coach = $coach;
    }

    private function obtainActivity(int $numItems = 5): Collection
    {
        return Activity::causedBy($this->coach)->orderBy('id', 'desc')->limit($numItems)->get();
    }

    private function obtainCoordinatedCoaches(): Collection
    {

        $coaches = collect();

        foreach ($this->coach->coachCoordinator as $coachCoordinator) {
            $coaches->push($coachCoordinator->coach);
        }

        $coaches = $coaches->sortBy(function ($coach) {
            return $coach->writeFullName();
        });

        return $coaches;
    }

    public function obtainCoordinatorCoaches(): Collection
    {

        $coaches = collect();

        if ($this->coach->coachCoordinated) {
            $item = $this->coach->coachCoordinated;
            $coaches->push($item->coordinator);
        }

        return $coaches;
    }

    public function obtainLastZoomRecording(int $numItems = 5): Collection
    {

        $zoomUser = $this->coach->zoomUser;

        if (! $zoomUser) {
            return collect();
        }

        return $this->zoomRecordingRepository->findLastItemsNotStartedByZoomUser($zoomUser, 5);
    }

    public function obtainSessionsReviews(): ReviewsWithStats
    {

        $average = $this->coachReviewRepository->averageByCoach($this->coach);
        $total = $this->coachReviewRepository->countByCoach($this->coach);

        $reviews = $this->coachReviewRepository->last($this->coach);

        return new ReviewsWithStats($reviews, $total, $average);
    }

    public function obtainFeedbacks(): Feedbacks
    {

        $feedbacksResult = $this->coachFeedbackRepository->obtainFromCoach($this->coach);

        $feedbacks = new Feedbacks();
        foreach ($feedbacksResult as $feedbackResult) {

            $feedback = new CoachFeedbackWrapper($feedbackResult);
            $feedbacks->add($feedback);
        }

        return $feedbacks;
    }
}
