<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;


class StudentClassNotifier extends CourseFieldNotifier
{
    const KEY = 'course_student_class_notifier';

    public function key(): string
    {
        return self::KEY;
    }
}
