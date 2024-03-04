<?php

namespace App\Src\NotificationDomain\Notification\Action\Command;

use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\NotificationDomain\Notification\Service\Message;
use App\Src\NotificationDomain\Notification\Service\Recipients;
use App\Src\NotificationDomain\NotificationRecipient\Model\NotificationRecipient;
use Carbon\Carbon;

class NotificationCreator
{
    protected function createNotification(Message $message, Recipients $recipients, int $typeId): Notification
    {

        $notification = new Notification();
        $notification->notification_type_id = $typeId;
        $notification->content = $message->get();
        $notification->notification_at = Carbon::now();
        $notification->save();

        foreach ($recipients->get() as $id) {

            $recipient = new NotificationRecipient();
            $recipient->notification_id = $notification->id;
            $recipient->user_id = $id;
            $recipient->save();
        }

        return $notification;
    }
}
