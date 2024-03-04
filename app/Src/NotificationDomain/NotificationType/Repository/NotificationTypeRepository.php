<?php

namespace App\Src\NotificationDomain\NotificationType\Repository;

use App\Src\NotificationDomain\NotificationLevel\Model\NotificationLevel;
use App\Src\NotificationDomain\NotificationType\Model\NotificationType;

class NotificationTypeRepository
{
    public function obtainFromLevel(NotificationLevel $notificationLevel)
    {
        return NotificationType::where('notification_level_id', $notificationLevel->id)->orderBy('name')->get();
    }

    public function obtainCoachingFormChanged(){
        return NotificationType::with('level')->where('id', 1)->first();
    }

    public function obtainStudentChangeCourseSection(){
        return NotificationType::with('level')->where('id', 9)->first();
    }
}
