<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;


class LanguageNotifier extends CourseFieldNotifier
{
    const KEY = 'course_language_notifier';

    public function key(): string
    {
        return self::KEY;
    }
}
