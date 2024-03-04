<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;

use App\Src\CourseDomain\Course\Model\Course;
use App\Src\NotificationDomain\Notification\Model\Notification;
use App\Src\NotificationDomain\Notification\Service\ChangeCollection;
use App\Src\NotificationDomain\Notification\Service\DataExtra\DataExtraCollection;
use App\Src\NotificationDomain\Notification\Service\DataExtra\DataExtraIdItem;
use App\Src\NotificationDomain\Notification\Service\Notifiers\Notifier;
use App\Src\NotificationDomain\Notification\Service\Notifiers\RecipientNotifier;
use App\Src\NotificationDomain\NotificationType\Repository\NotificationTypeRepository;
use App\Src\UserDomain\User\Model\User;
use Carbon\Carbon;


abstract class CourseFieldNotifier implements Notifier
{
    private NotificationTypeRepository $notificationTypeRepository;

    private RecipientNotifier $recipientNotifier;

    public function __construct (NotificationTypeRepository $notificationTypeRepository, RecipientNotifier $recipientNotifier){

        $this->notificationTypeRepository = $notificationTypeRepository;
        $this->recipientNotifier = $recipientNotifier;
    }

    abstract public function key():string;

    public function publish(User $user, Course $course, ChangeCollection $changeCollection):Notification
    {
        $type = $this->notificationTypeRepository->obtainCoachingFormChanged();

        $notification = new Notification();
        $notification->notification_type_id = $type->id;
        $notification->notifier_id = $user->id;
        $notification->content = $this->content();

        $dataExtra = $this->obtainExtraData($course, $changeCollection);

        $dataExtraAsArray = $dataExtra->toArray();
        $notification->extra = $dataExtraAsArray;

        $notification->notification_at = Carbon::now();

        $notification->save();

        $this->recipientNotifier->notifyToManagers($notification);

        return $notification;
    }

    private function obtainExtraData (Course $course, ChangeCollection $changeCollection):DataExtraCollection{

        $dataExtraCollection = new DataExtraCollection($this->key());

        $item = new DataExtraIdItem('course_id', $course->id);
        $dataExtraCollection->add($item);

        foreach ($changeCollection->convertToDataExtraItems() as $extraItem){
            $dataExtraCollection->add($extraItem);
        }

        return $dataExtraCollection;
    }

    private function content ():string{
        return 'There is a new modification of Coaching Form';
    }
}
