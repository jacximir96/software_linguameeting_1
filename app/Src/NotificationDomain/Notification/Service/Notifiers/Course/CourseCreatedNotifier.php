<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;


class CourseCreatedNotifier extends CourseFieldNotifier
{
    const KEY = 'course_created_notifier';


    public function key(): string
    {
        return self::KEY;
    }
}
