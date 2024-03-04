<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment;


use App\Src\CourseDomain\Section\Model\Section;
use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\NotificationDomain\Notification\Service\ChangeCollection;
use App\Src\NotificationDomain\Notification\Service\DataExtra\DataExtraCollection;
use App\Src\NotificationDomain\Notification\Service\DataExtra\DataExtraIdItem;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Notifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\RecipientNotifier;
use App\Src\NotificationDomain\NotificationType\Repository\NotificationTypeRepository;
use App\Src\StudentDomain\Enrollment\Model\Enrollment;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;


abstract class EnrollmentFieldNotifier implements Notifier
{
    private NotificationTypeRepository $notificationTypeRepository;

    private RecipientNotifier $recipientNotifier;

    public function __construct (NotificationTypeRepository $notificationTypeRepository, RecipientNotifier $recipientNotifier){

        $this->notificationTypeRepository = $notificationTypeRepository;
        $this->recipientNotifier = $recipientNotifier;
    }

    abstract public function key():string;

    public function publish(User $user, Enrollment $enrollment, ChangeCollection $changeCollection):Notification
    {
        $type = $this->notificationTypeRepository->obtainStudentChangeCourseSection();

        $notification = new Notification();
        $notification->notification_type_id = $type->id;
        $notification->notifier_id = $user->id;
        $notification->content = $this->content();

        $dataExtra = $this->obtainExtraData($enrollment, $changeCollection);

        $dataExtraAsArray = $dataExtra->toArray();
        $notification->extra = $dataExtraAsArray;

        $notification->notification_at = Carbon::now();
        $notification->save();

        $this->sendNotifyToUsers($notification, $user);

        return $notification;
    }

    private function obtainExtraData (Enrollment $enrollment, ChangeCollection $changeCollection):DataExtraCollection{

        $dataExtraCollection = new DataExtraCollection($this->key());

        $item = new DataExtraIdItem('enrollment_id', $enrollment->id);
        $dataExtraCollection->add($item);

        foreach ($changeCollection->convertToDataExtraItems() as $extraItem){
            $dataExtraCollection->add($extraItem);
        }

        return $dataExtraCollection;
    }

    private function sendNotifyToUsers (Notification $notification, User $user){

        $this->recipientNotifier->notifyToManagers($notification);

        $users = collect();
        $users->push($user);

        $this->recipientNotifier->notifyToUsers($notification, $users);

    }

    private function content ():string{
        return 'The student change the course/section';
    }
}
