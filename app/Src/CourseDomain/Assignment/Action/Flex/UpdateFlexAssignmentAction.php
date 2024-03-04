<?php

namespace App\Src\CourseDomain\Assignment\Action\Flex;

use App\Src\CourseDomain\Assignment\Action\Command\ReplicateAssignmentCommand;
use App\Src\CourseDomain\Assignment\Action\Command\UpdateAssignmentCommand;
use App\Src\CourseDomain\Assignment\Model\Assignment;
use App\Src\CourseDomain\Assignment\Request\FormAssignmentRequest;
use App\Src\CourseDomain\Flex\Service\FlexSession;
use App\Src\CourseDomain\Section\Model\Section;

/**
 * Actualizar los assignments de una sección (vista modal):
 *      - si es one to one, actualiza solo para la sesión de la sección.
 *      - si es small group actualiza para la misma sessión del resto de secciones.
 */
class UpdateFlexAssignmentAction
{
    private UpdateAssignmentCommand $updateAssignmentCommand;

    private ReplicateAssignmentCommand $replicateAssignmentCommand;

    public function __construct(UpdateAssignmentCommand $updateAssignmentCommand, ReplicateAssignmentCommand $replicateAssignmentCommand)
    {

        $this->updateAssignmentCommand = $updateAssignmentCommand;
        $this->replicateAssignmentCommand = $replicateAssignmentCommand;
    }

    public function handle(FormAssignmentRequest $request, Section $section, FlexSession $flexSession): Assignment
    {

        $course = $section->course;

        $assignment = $this->updateAssignmentCommand->updateForFlex($request, $section, $flexSession);

        if ($course->conversationPackage->sessionType->isSmallGroup()) {
            $this->replicateAssignmentToOtherSections($assignment, $section, $flexSession);
        }

        return $assignment;
    }

    //copiar assignment a la misma sessión de otras secciones del curso
    private function replicateAssignmentToOtherSections(Assignment $assignment, Section $originalSection, FlexSession $flexSession)
    {

        $course = $originalSection->course;

        foreach ($course->section as $section) {

            if ($originalSection->isSame($section)) {
                continue;
            }

            $this->replicateAssignmentCommand->replicateForFlex($assignment, $section, $flexSession);
        }
    }
}
