<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;


class ConversationPackageNotifier extends CourseFieldNotifier
{
    const KEY = 'course_conversation_package_notifier';

    public function key(): string
    {
        return self::KEY;
    }
}
