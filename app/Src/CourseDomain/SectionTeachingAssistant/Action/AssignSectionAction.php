<?php

namespace App\Src\CourseDomain\SectionTeachingAssistant\Action;

use App\Src\CourseDomain\Section\Exception\AssistantAlreadyAssignedAsInstructor;
use App\Src\CourseDomain\Section\Model\Section;
use App\Src\CourseDomain\SectionTeachingAssistant\Exception\TeachingAssistantExistsInSection;
use App\Src\CourseDomain\SectionTeachingAssistant\Model\SectionTeachingAssistant;
use App\Src\CourseDomain\SectionTeachingAssistant\Repository\SectionTeachingAssistantRepository;
use App\Src\UserDomain\User\Model\User;

class AssignSectionAction
{
    private SectionTeachingAssistantRepository $sectionTeachingAssistantRepository;

    public function __construct(SectionTeachingAssistantRepository $sectionTeachingAssistantRepository)
    {
        $this->sectionTeachingAssistantRepository = $sectionTeachingAssistantRepository;
    }

    public function handle(Section $section, User $teachingAssistant): SectionTeachingAssistant
    {
        $this->checkExistsAsInstructorInSection($section, $teachingAssistant);

        $this->checkExistsTeachingAssistantInSection($section, $teachingAssistant);

        return $this->createRelation($section, $teachingAssistant);
    }

    private function checkExistsAsInstructorInSection(Section $section, User $teachingAssistant)
    {

        $instructor = $section->instructor;

        if ($instructor->isSame($teachingAssistant)) {
            throw new AssistantAlreadyAssignedAsInstructor();
        }

    }

    private function checkExistsTeachingAssistantInSection(Section $section, User $teachingAssistant)
    {
        $relation = $this->sectionTeachingAssistantRepository->find($section, $teachingAssistant);

        if ($relation) {
            throw new TeachingAssistantExistsInSection();
        }
    }

    private function createRelation(Section $section, User $teachingAssistant): SectionTeachingAssistant
    {
        $teaching = new SectionTeachingAssistant();
        $teaching->section_id = $section->id;
        $teaching->teacher_id = $teachingAssistant->id;

        $teaching->save();

        return $teaching;
    }
}
