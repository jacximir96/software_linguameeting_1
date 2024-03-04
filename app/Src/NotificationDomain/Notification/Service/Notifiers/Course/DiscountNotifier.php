<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;


class DiscountNotifier extends CourseFieldNotifier
{
    const KEY = 'course_discount_notifier';

    public function key(): string
    {
        return self::KEY;
    }
}
