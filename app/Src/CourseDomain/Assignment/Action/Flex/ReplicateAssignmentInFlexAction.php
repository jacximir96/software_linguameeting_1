<?php

namespace App\Src\CourseDomain\Assignment\Action\Flex;

use App\Src\CourseDomain\Assignment\Action\Command\ReplicateAssignmentCommand;
use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\Assignment\Repository\AssignmentRepository;
use App\Src\CourseDomain\AssignmentFile\Action\DeleteAssignmentFileAction;
use App\Src\CourseDomain\AssignmentFile\Model\AssignmentFile;
use App\Src\CourseDomain\Course\Model\Course;

/**
 * Guarda los assigments de una sección-sesión para el resto de sesiones de la siguiente forma:
 *
 *  one on one: replica para todas las sessiones de la sección actualizada.
 *  small group: replica para todas las sesiones de todas las secciones del curso.
 */
class ReplicateAssignmentInFlexAction
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

    private function replicateInAllSections()
    {

        $sessions = $this->course->obtainFlexSessions();

        foreach ($this->course->section as $section) {

            foreach ($sessions->get() as $flexSession) {
                $this->replicateAssignmentCommand->replicateForFlex($this->originalAssignment, $section, $flexSession);

            }
        }
    }

    private function replicateInCurrentSection()
    {

        $section = $this->originalAssignment->section;

        $sessions = $this->course->obtainFlexSessions();

        foreach ($sessions->get() as $flexSession) {
            $this->replicateAssignmentCommand->replicateForFlex($this->originalAssignment, $section, $flexSession);
        }
    }
}
