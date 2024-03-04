<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;


class CoachingWeeksNotifier extends CourseFieldNotifier
{
    const KEY = 'course_coaching_weeks_notifier';

    public function key(): string
    {
        return self::KEY;
    }
}
