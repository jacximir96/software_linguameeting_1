<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Section;


class InstructorNotifier extends SectionFieldNotifier
{
    const KEY = 'section_instructor_notifier';

    public function key(): string
    {
        return self::KEY;
    }
}
