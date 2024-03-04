<?php

namespace App\Src\CourseDomain\Course\Presenter\Log;

use App\Src\ActivityLog\Model\Activity;
use App\Src\CourseDomain\Course\Model\Course;
use Illuminate\Support\Collection;

class DocumentationLogPresenter
{
    private Collection $activity;

    public function handle(Course $course): DocumentationLogResponse
    {

        $this->activity = collect();

        $this->addCourseLog($course);

        $this->addSectionsLog($course);

        $this->sortRecords();

        return new DocumentationLogResponse($this->activity);
    }

    private function addCourseLog(Course $course)
    {
        $this->activity =  Activity::forSubject($course)
            ->where('description', config('linguameeting_log.activity.keys.course.send_documentation'))
            ->orderByDesc('id')
            ->get();
    }

    private function addSectionsLog(Course $course)
    {

        foreach ($course->section as $section) {

            $activity = Activity::forSubject($section)
                ->where('description', config('linguameeting_log.activity.keys.section.send_documentation'))
                ->orderByDesc('id')->get();

            foreach ($activity as $record) {
                $this->activity->push($record);
            }
        }
    }

    private function sortRecords()
    {
        $this->activity = $this->activity->sortByDesc(function ($record) {
            return $record->id;
        });
    }
}
