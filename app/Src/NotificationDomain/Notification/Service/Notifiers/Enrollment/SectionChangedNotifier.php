<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Enrollment;


class SectionChangedNotifier extends EnrollmentFieldNotifier
{
    const KEY = 'student_change_section_notifier';


    public function key(): string
    {
        return self::KEY;
    }
}
