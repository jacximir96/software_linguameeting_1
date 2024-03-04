<?php

namespace App\Src\CourseDomain\Section\Action;

use App\Src\CourseDomain\Assignment\Action\Command\DeleteAssignmentCommand;
use App\Src\CourseDomain\Section\Exception\SectionHasStudents;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\SectionTeachingAssistant\Action\DeleteSectionTeachingAssistantAction;

class DeleteSectionAction
{
    private Section $section;

    private DeleteSectionTeachingAssistantAction $deleteSectionTeachingAssistantAction;

    private DeleteAssignmentCommand $deleteAssignmentCommand;

    public function __construct(DeleteSectionTeachingAssistantAction $deleteSectionTeachingAssistantAction, DeleteAssignmentCommand $deleteAssignmentCommand)
    {
        $this->deleteSectionTeachingAssistantAction = $deleteSectionTeachingAssistantAction;
        $this->deleteAssignmentCommand = $deleteAssignmentCommand;
    }

    public function handle(Section $section)
    {
        $this->initialize($section);

        $this->checkSectionHasNotStudents();

        $this->deleteAssignments();

        $this->deleteTeachingAssistants();

        $this->deleteSection();
    }

    private function initialize(Section $section)
    {
        $this->section = $section;
    }

    private function checkSectionHasNotStudents()
    {
        if ($this->section->enrollment()->count()){
            throw new SectionHasStudents();
        }
    }

    private function deleteAssignments()
    {
        $this->deleteAssignmentCommand->deleteFromSection($this->section);
    }

    private function deleteTeachingAssistants()
    {
        foreach ($this->section->teachingAssistant as $teachingAssistant) {
            $this->deleteSectionTeachingAssistantAction->handle($teachingAssistant);
        }
    }

    private function deleteSection()
    {
        $this->section->delete();
    }
}
