<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers;


use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\NotificationDomain\NotificationRecipient\Model\NotificationRecipient;
use App\Src\UserDomain\User\Repository\UserRepository;
use Illuminate\Support\Collection;

class RecipientNotifier
{

    private UserRepository $userRepository;

    public function __construct (UserRepository $userRepository){

        $this->userRepository = $userRepository;
    }

    public function notifyToManagers (Notification $notification){

        $users = $this->userRepository->notificationUsers();

        foreach ($users as $user){

            $item = new NotificationRecipient();
            $item->notification_id = $notification->id;
            $item->user_id = $user->id;
            $item->save();
        }
    }

    public function notifyToUsers (Notification $notification, Collection $users){
        foreach ($users as $user){

            $item = new NotificationRecipient();
            $item->notification_id = $notification->id;
            $item->user_id = $user->id;
            $item->save();
        }
    }
}
