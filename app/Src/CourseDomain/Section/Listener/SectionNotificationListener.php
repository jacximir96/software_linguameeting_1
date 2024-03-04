<?php
namespace App\Src\CourseDomain\Section\Listener;

use App\Src\CourseDomain\Course\Event\ChangeCourseEvent;
use App\Src\CourseDomain\Course\Service\CourseNotification;
use App\Src\CourseDomain\Section\Event\ChangeSectionEvent;
use App\Src\CourseDomain\Section\Service\SectionNotification;

class SectionNotificationListener
{

    private SectionNotification $sectionNotification;

    public function __construct (SectionNotification $sectionNotification){

        $this->sectionNotification = $sectionNotification;
    }

    public function handle(ChangeSectionEvent $event){
       $this->sectionNotification->publish($event->user(), $event->sectionChanges());
    }
}
