<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;


class CourseDatesNotifier extends CourseFieldNotifier
{
    const KEY = 'course_date_notifier';


    public function key(): string
    {
        return self::KEY;
    }
}
