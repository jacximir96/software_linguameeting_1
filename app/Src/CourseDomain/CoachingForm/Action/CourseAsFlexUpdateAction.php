<?php

namespace App\Src\CourseDomain\CoachingForm\Action;

use App\Src\CourseDomain\Assignment\Action\Command\DeleteAssignmentCommand;
use App\Src\CourseDomain\Course\Model\Course;

class CourseAsFlexUpdateAction
{
    private DeleteAssignmentCommand $deleteAssignmentCommand;

    public function __construct(DeleteAssignmentCommand $deleteAssignmentCommand)
    {

        $this->deleteAssignmentCommand = $deleteAssignmentCommand;
    }

    public function handle(Course $course): Course
    {
        if (! $course->isFlex()) {
            $this->removeAssignments($course);
        }

        return $this->setCourseAsFlex($course);
    }

    private function removeAssignments(Course $course)
    {
        $this->deleteAssignmentCommand->deleteFromCourse($course);
    }

    private function setCourseAsFlex(Course $course): Course
    {

        $course->is_flex = true;
        $course->save();

        return $course;
    }
}
