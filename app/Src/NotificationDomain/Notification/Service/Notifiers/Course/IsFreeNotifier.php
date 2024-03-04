<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;


class IsFreeNotifier extends CourseFieldNotifier
{
    const KEY = 'course_is_free_notifier';

    public function key(): string
    {
        return self::KEY;
    }
}
