<?php

namespace App\Src\CourseDomain\CoachingForm\Action\CoachingWeek;

use App\Src\CourseDomain\Assignment\Action\Command\DeleteAssignmentCommand;
use App\Src\CourseDomain\CoachingForm\Exception\StudentsWithSessionsToChangeWeeks;
use App\Src\CourseDomain\CoachingWeek\Model\CoachingWeek;
use App\Src\CourseDomain\Course\Model\Course;
use App\Src\CourseDomain\SessionDomain\EnrollmentSession\Repository\EnrollmentSessionRepository;
use App\Src\TimeDomain\Date\Service\WeekCalendar;

class DifferentWeeksUpdateCommand
{
    private WeekCalendar $weekCalendar;

    private Course $course;

    private WeekCreateCommand $createWeekCommand;

    private DeleteAssignmentCommand $deleteAssignmentCommand;

    private EnrollmentSessionRepository $enrollmentSessionRepository;

    public function __construct(WeekCreateCommand $createWeekCommand, DeleteAssignmentCommand $deleteAssignmentCommand, EnrollmentSessionRepository $enrollmentSessionRepository)
    {
        $this->createWeekCommand = $createWeekCommand;
        $this->deleteAssignmentCommand = $deleteAssignmentCommand;
        $this->enrollmentSessionRepository = $enrollmentSessionRepository;
    }

    public function handle(WeekCalendar $weekCalendar, Course $course)
    {
        $this->initialize($weekCalendar, $course);

        $this->checkCourseHasStudentsAssigned();

        $this->deleteWeeks();

        $this->deleteAssignments();

        $this->regenerateCoachingWeek();
    }

    private function initialize(WeekCalendar $weekCalendar, Course $course)
    {
        $this->weekCalendar = $weekCalendar;
        $this->course = $course;
    }

    private function checkCourseHasStudentsAssigned()
    {
        if ($this->courseHasStudentsWithSessionsReserverd()) {
            throw new StudentsWithSessionsToChangeWeeks(trans('coaching_form.exception.students_with_sessions_to_change_weeks'));
        }
    }

    private function courseHasStudentsWithSessionsReserverd(): bool
    {
        return (bool)$this->enrollmentSessionRepository->countEnrollmentSessionsFromCourse($this->course);
    }

    private function deleteWeeks()
    {
        CoachingWeek::query()
            ->where('course_id', $this->course->id)
            ->where('is_makeup', 0)
            ->delete();
    }

    private function deleteAssignments()
    {
        $this->deleteAssignmentCommand->deleteFromCourse($this->course);
    }

    private function regenerateCoachingWeek()
    {
        $this->createWeekCommand->handle($this->weekCalendar, $this->course);
    }
}
