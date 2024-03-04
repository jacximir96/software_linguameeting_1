<?php

namespace App\Src\NotificationDomain\NotificationRecipient\Action;

use App\Src\NotificationDomain\NotificationRecipient\Model\NotificationRecipient;
use Carbon\Carbon;

class MarkNotificationReadAction
{
    public function handle(NotificationRecipient $notificationRecipient): NotificationRecipient
    {

        if ($notificationRecipient->hasBeenReaded()) {
            $notificationRecipient->read_at = null;
        } else {
            $notificationRecipient->read_at = Carbon::now();
        }

        $notificationRecipient->save();

        return $notificationRecipient;
    }
}
