<?php

namespace App\Src\CourseDomain\Course\Presenter\Log;

use App\Src\ActivityLog\Model\Activity;
use App\Src\ActivityLog\Service\ActivityCollect;
use App\Src\ActivityLog\Service\SectionActivity;
use App\Src\CourseDomain\Course\Model\Course;


class ActivityLogPresenter
{
    private ActivityCollect $activityCollect;

    public function __construct(ActivityCollect $activityCollect)
    {

        $this->activityCollect = $activityCollect;
    }

    public function handle(Course $course): ActivityLogResponse
    {

        $this->initialize();

        $this->obtainActivityFromCourse($course);

        $this->obtainActivityFromSections($course);

        return new ActivityLogResponse($this->activityCollect);
    }

    private function initialize()
    {
        $this->activityCollect->clean();
    }

    private function obtainActivityFromCourse(Course $course)
    {
        $activities = Activity::forSubject($course)->get();

        foreach ($activities as $activity){
            $this->activityCollect->push($activity);
        }

    }

    private function obtainActivityFromSections(Course $course)
    {

        foreach ($course->section as $section) {

            $activity = Activity::forSubject($section)->get();

            foreach ($activity as $item) {
                $this->activityCollect->push($item);
            }
        }
    }
}
