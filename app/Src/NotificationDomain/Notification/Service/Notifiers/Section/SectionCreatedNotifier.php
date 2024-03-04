<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Section;


class SectionCreatedNotifier extends SectionFieldNotifier
{
    const KEY = 'enrollment_updated_notifier';


    public function key(): string
    {
        return self::KEY;
    }
}
