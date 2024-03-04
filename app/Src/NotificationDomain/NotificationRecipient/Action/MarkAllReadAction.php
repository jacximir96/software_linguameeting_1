<?php

namespace App\Src\NotificationDomain\NotificationRecipient\Action;

use App\Src\NotificationDomain\Notification\Repository\NotificationRepository;
use App\Src\Shared\Service\CriteriaSearch;

class MarkAllReadAction
{
    private NotificationRepository $notificationRepository;

    public function __construct(NotificationRepository $notificationRepository)
    {

        $this->notificationRepository = $notificationRepository;
    }

    public function handle(CriteriaSearch $criteriaSearch)
    {

        $this->notificationRepository->markAll($criteriaSearch, true);
    }
}
