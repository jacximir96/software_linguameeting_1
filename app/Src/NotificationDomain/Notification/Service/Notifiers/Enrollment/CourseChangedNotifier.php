<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment;


class CourseChangedNotifier extends EnrollmentFieldNotifier
{
    const KEY = 'student_change_course_notifier';


    public function key(): string
    {
        return self::KEY;
    }
}
