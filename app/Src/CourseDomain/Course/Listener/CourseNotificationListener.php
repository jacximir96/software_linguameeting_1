<?php
namespace App\Src\CourseDomain\Course\Listener;

use App\Src\CourseDomain\Course\Event\ChangeCourseEvent;
use App\Src\CourseDomain\Course\Service\CourseNotification;

class CourseNotificationListener
{

    private CourseNotification $courseNotification;

    public function __construct (CourseNotification $courseNotification){

        $this->courseNotification = $courseNotification;
    }

    public function handle(ChangeCourseEvent $event){

       $this->courseNotification->publish($event->user(), $event->courseChanges());
    }
}
