<?php

namespace App\Src\CourseDomain\Assignment\Action\Week;

use App\Src\CourseDomain\Assignment\Action\Command\ReplicateAssignmentCommand;
use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\AssignmentFile\Action\DeleteAssignmentFileAction;
use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;
use App\Src\CourseDomain\Course\Model\Course;

/**
 * Dado un curso small group: dado un assignment, lo replica para todas las sesiones de todas las secciones del curso.
 * Dado un curso one on one: dado un assignment, lo replica para todas las sessiones de la sección del assignment
 */
class ReplicateAssignmentInWeekAction
{
    private Course $course;

    private Assignment $originalAssignment;

    private ?AssignmentFile $originalAssignmentFile;

    private AssignmentRepository $assignmentRepository;

    private DeleteAssignmentFileAction $deleteAssignmentFileAction;

    private ReplicateAssignmentCommand $replicateAssignmentCommand;

    public function __construct(AssignmentRepository $assignmentRepository,
        DeleteAssignmentFileAction $deleteAssignmentFileAction,
        ReplicateAssignmentCommand $replicateAssignmentCommand)
    {

        $this->assignmentRepository = $assignmentRepository;
        $this->deleteAssignmentFileAction = $deleteAssignmentFileAction;
        $this->replicateAssignmentCommand = $replicateAssignmentCommand;
    }

    public function handle(Course $course, Assignment $originalAssignment)
    {

        $this->initialize($course, $originalAssignment);

        if ($this->isAssignmentForSmallGroup()) {
            $this->replicateInAllSections();
        } else {
            $this->replicateInCurrentSection();
        }
    }

    private function initialize(Course $course, Assignment $originalAssignment)
    {
        $this->course = $course;
        $this->originalAssignment = $originalAssignment;
        $this->originalAssignmentFile = $originalAssignment->file;
    }

    private function isAssignmentForSmallGroup(): bool
    {
        return $this->course->conversationPackage->sessionType->isSmallGroup();
    }

    private function replicateInCurrentSection()
    {

        $section = $this->originalAssignment->section;

        $coachingWeeks = $this->course->coachingWeeksOrderedWithoutMakeUps();

        foreach ($coachingWeeks as $coachingWeek) {
            $this->replicateAssignmentCommand->replicateForWeek($this->originalAssignment, $section, $coachingWeek);
        }
    }

    private function replicateInAllSections()
    {

        $coachingWeeks = $this->course->coachingWeeksOrderedWithoutMakeUps();

        foreach ($this->course->section as $section) {

            foreach ($coachingWeeks as $coachingWeek) {
                $this->replicateAssignmentCommand->replicateForWeek($this->originalAssignment, $section, $coachingWeek);
            }
        }
    }
}
