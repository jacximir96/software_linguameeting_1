<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;


class HolidaysNotifier extends CourseFieldNotifier
{
    const KEY = 'course_holidays_notifier';

    public function key(): string
    {
        return self::KEY;
    }
}
