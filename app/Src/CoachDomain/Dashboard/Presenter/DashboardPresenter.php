<?php

namespace App\Src\CoachDomain\Dashboard\Presenter;

use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReview\Repository\CoachReviewRepository;
use App\Src\CoachDomain\FeedbackDomain\ReviewDomain\CoachReviewOption\Repository\CoachReviewOptionRepository;
use App\Src\CourseDomain\SessionDomain\Session\Repository\SessionRepository;
use App\Src\MessagingDomain\Thread\Repository\ThreadRepository;
use App\Src\NotificationDomain\Notification\Repository\NotificationRepository;
use App\Src\Shared\Service\CriteriaSearch;
use App\Src\TimeDomain\Date\Service\PeriodsBuilder;
use App\Src\UserDomain\User\Model\User;
use Illuminate\Support\Collection;

class DashboardPresenter
{
    //construct
    private CoachReviewRepository $coachReviewRepository;

    private CoachReviewOptionRepository $coachReviewOptionRepository;

    private NotificationRepository $notificationRepository;

    private ThreadRepository $threadRepository;

    private SessionRepository $sessionRepository;

    private PeriodsBuilder $periodsBuilder;

    //status
    private User $coach;

    public function __construct(CoachReviewRepository $coachReviewRepository,
        CoachReviewOptionRepository $coachReviewOptionRepository,
        NotificationRepository $notificationRepository, ThreadRepository $threadRepository,
        SessionRepository $sessionRepository,
        PeriodsBuilder $periodsBuilder)
    {
        $this->coachReviewRepository = $coachReviewRepository;
        $this->coachReviewOptionRepository = $coachReviewOptionRepository;
        $this->notificationRepository = $notificationRepository;
        $this->threadRepository = $threadRepository;
        $this->sessionRepository = $sessionRepository;
        $this->periodsBuilder = $periodsBuilder;
    }

    public function handle(User $coach)
    {

        $this->initialize($coach);

        $reviewsStats = $this->coachReviewRepository->reviewStats($coach);

        $mostSelected = $this->coachReviewOptionRepository->obtainMoreSelectedByCoach($coach);

        $notifications = $this->obtainNotReadNotifications();

        $threadsNotRead = $this->obtainThreadsNotRead();

        $sessions = $this->obtainTodaySessions();

        return new DashboardResponse($reviewsStats, $mostSelected, $notifications, $threadsNotRead, $sessions);
    }

    private function initialize(User $coach)
    {
        $this->coach = $coach;
    }

    private function obtainNotReadNotifications(): Notifications
    {

        $filter = [
            'recipient_id' => [$this->coach->id],
            'read_status' => config('linguameeting.notification.read_status.no.key'),
        ];

        $criteria = new CriteriaSearch($filter);
        $criteria->withoutPaginate();
        $criteria->withSizePage(5);

        $notifications = $this->notificationRepository->search($criteria);

        return new Notifications(collect($notifications->items()), $notifications->total());
    }

    private function obtainThreadsNotRead(): Messaging
    {

        $messaging = $this->threadRepository->obtainLatestInboxNotRead($this->coach, 3);

        return new Messaging(collect($messaging->items()), $messaging->total());
    }

    private function obtainTodaySessions(): Collection
    {

        $period = $this->periodsBuilder->buildTodayFromStartToEndFromTimezone($this->coach->timeZone);

        return $this->sessionRepository->obtainSessionForCoachInPeriod($this->coach, $period, $this->coach->timezone);
    }
}
