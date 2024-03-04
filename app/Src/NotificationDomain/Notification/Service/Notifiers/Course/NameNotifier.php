<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;


class NameNotifier extends CourseFieldNotifier
{
    const KEY = 'course_name_notifier';

    public function key(): string
    {
        return self::KEY;
    }
}
