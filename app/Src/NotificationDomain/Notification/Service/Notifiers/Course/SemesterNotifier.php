<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;


class SemesterNotifier extends CourseFieldNotifier
{
    const KEY = 'course_semester_notifier';

    public function key(): string
    {
        return self::KEY;
    }
}
