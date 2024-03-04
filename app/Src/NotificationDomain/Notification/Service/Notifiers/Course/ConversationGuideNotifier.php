<?php
namespace App\Src\NotificationDomain\Notification\Service\Notifiers\Course;


class ConversationGuideNotifier extends CourseFieldNotifier
{
    const KEY = 'course_conversation_guide_notifier';

    public function key(): string
    {
        return self::KEY;
    }
}
