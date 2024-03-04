<?php

namespace App\Src\NotificationDomain\Notification\Repository;

use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\NotificationDomain\NotificationRecipient\Model\NotificationRecipient;
use App\Src\Shared\Repository\BuilderSpecificDateRepository;
use App\Src\Shared\Service\CriteriaSearch;
use Carbon\Carbon;

class NotificationRepository
{
    private BuilderSpecificDateRepository $builderSpecificDateRepository;

    public function __construct(BuilderSpecificDateRepository $builderSpecificDateRepository)
    {

        $this->builderSpecificDateRepository = $builderSpecificDateRepository;
    }

    public function search(CriteriaSearch $criteriaSearch)
    {

        $query = $this->buildQuery($criteriaSearch);

        if ($criteriaSearch->hasSizePage()) {
            return $query->orderBy('notification_at', 'desc')
                ->paginate($criteriaSearch->sizePage());
        }

        if ($criteriaSearch->hasSizePage()) {
            return $query->orderBy('notification_at', 'desc')
                ->paginate($criteriaSearch->sizePage());
        }

        return $query->orderBy('notification_at', 'desc')
            ->paginate(config('linguameeting.items_per_page'));
    }

    public function markAll(CriteriaSearch $criteriaSearch, bool $markAsRead)
    {

        $queryNotification = $this->buildQuery($criteriaSearch)->select('notification.id');
        $notificationsIds = $queryNotification->get()->pluck('id');

        $query = NotificationRecipient::query()
            ->whereIn('notification_id', $notificationsIds);

        if ($markAsRead) {
            $now = Carbon::now();
            $query->update(['read_at' => $now]);
        } else {
            $query->update(['read_at' => null]);
        }
    }

    public function relation(): array
    {

        return [
            'notifier',
            'type',
            'type.level',
            'recipient',
        ];
    }

    private function buildQuery(CriteriaSearch $criteriaSearch)
    {

        $query = Notification::query()
            ->with($this->relation())
            ->whereHas('recipient', function ($query) use ($criteriaSearch) {
                $query->whereIn('user_id', $criteriaSearch->get('recipient_id'));

                if ($this->searchReaded($criteriaSearch)) {
                    $query->whereNotNull('read_at');
                } elseif ($this->searchNotReaded($criteriaSearch)) {
                    $query->whereNull('read_at');
                }
            });

        if ($criteriaSearch->searchBy('specific_date')) {
            $this->builderSpecificDateRepository->buildQuery($query, $criteriaSearch, 'notification_at');
        } elseif ($this->filterByDates($criteriaSearch)) {

            $start = $criteriaSearch->getDate('start_date')->startOfDay();
            $end = $criteriaSearch->getDate('end_date')->endOfDay();

            $query->whereBetween('notification_at', [$start->toDateTimeString(), $end->toDateTimeString()]);
        }

        if ($criteriaSearch->searchBy('type_id')) {
            $query->where('notification_type_id', $criteriaSearch->get('type_id'));
        }

        if ($criteriaSearch->searchBy('level_id')) {

            $query->whereHas('type.level', function ($query) use ($criteriaSearch) {
                $query->where('id', $criteriaSearch->get('level_id'));
            });
        }

        return $query;
    }

    private function searchReaded(CriteriaSearch $criteriaSearch): bool
    {

        if ($criteriaSearch->searchBy('read_status')) {
            return $criteriaSearch->get('read_status') == config('linguameeting.notification.read_status.yes.key');
        }

        return false;
    }

    private function searchNotReaded(CriteriaSearch $criteriaSearch): bool
    {

        if ($criteriaSearch->searchBy('read_status')) {
            return $criteriaSearch->get('read_status') == config('linguameeting.notification.read_status.no.key');
        }

        return false;
    }

    private function filterByDates(CriteriaSearch $criteriaSearch): bool
    {

        if (! $criteriaSearch->searchBy('start_date')) {
            return false;
        }

        if (! $criteriaSearch->searchBy('end_date')) {
            return false;
        }

        return true;
    }
}
